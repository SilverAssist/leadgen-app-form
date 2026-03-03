#!/bin/bash

###############################################################################
# LeadGen App Form Plugin - Release ZIP Creator
#
# Creates a properly structured ZIP file for WordPress plugin distribution
# The ZIP will have a versioned filename but the internal folder will be just "leadgen-app-form"
#
# Usage: ./scripts/create-release-zip.sh [version]
# If version is not provided, it will be extracted from the main plugin file
#
# @package LeadGenAppForm
# @since 1.0.1
# @author Silver Assist
# @version 1.0.4
###############################################################################

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

echo -e "${CYAN}=== LeadGen App Form Plugin Release ZIP Creator ===${NC}"
echo ""

# Get current directory (should be project root)
PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$PROJECT_ROOT"

# Check if we're in the right directory
if [ ! -f "leadgen-app-form.php" ]; then
    echo -e "${RED}❌ Error: leadgen-app-form.php not found. Make sure you're running this from the project root.${NC}"
    exit 1
fi

# Get version from parameter or extract from main plugin file
if [ -n "$1" ]; then
    VERSION="$1"
    echo -e "${YELLOW}📋 Using provided version: ${VERSION}${NC}"
else
    VERSION=$(grep "Version:" leadgen-app-form.php | grep -o '[0-9]\+\.[0-9]\+\.[0-9]\+' | head -1)
    echo -e "${YELLOW}📋 Extracted version from plugin file: ${VERSION}${NC}"
fi

if [ -z "$VERSION" ]; then
    echo -e "${RED}❌ Error: Could not determine version. Please provide version as argument or ensure leadgen-app-form.php has proper version header.${NC}"
    exit 1
fi

echo -e "${GREEN}📦 Creating ZIP for version: ${VERSION}${NC}"
echo ""

# Define files and directories to include
ZIP_NAME="leadgen-app-form-v${VERSION}.zip"
TEMP_DIR="/tmp/leadgen-app-form-release"
PLUGIN_DIR="${TEMP_DIR}/leadgen-app-form"

# Clean up any existing temp directory
if [ -d "$TEMP_DIR" ]; then
    rm -rf "$TEMP_DIR"
fi

# Create temporary directory structure
mkdir -p "$PLUGIN_DIR"

echo -e "${YELLOW}📋 Copying files...${NC}"

# Copy main plugin file
cp leadgen-app-form.php "$PLUGIN_DIR/"
echo "  ✅ leadgen-app-form.php copied"

# Copy documentation files
cp README.md "$PLUGIN_DIR/"
cp CHANGELOG.md "$PLUGIN_DIR/"
cp LICENSE "$PLUGIN_DIR/"
echo "  ✅ Documentation files copied"

# Copy includes directory
if [ -d "includes" ]; then
    cp -r includes "$PLUGIN_DIR/"
    echo "  ✅ includes/ directory copied"
fi

# Copy assets directory
if [ -d "assets" ]; then
    cp -r assets "$PLUGIN_DIR/"
    echo "  ✅ assets/ directory copied"
fi

# Copy blocks directory
if [ -d "blocks" ]; then
    cp -r blocks "$PLUGIN_DIR/"
    echo "  ✅ blocks/ directory copied"
fi

# Copy languages directory if it exists
if [ -d "languages" ]; then
    cp -r languages "$PLUGIN_DIR/"
    echo "  ✅ languages/ directory copied"
fi

# Copy composer.json if it exists (for PSR-4 autoloading)
if [ -f "composer.json" ]; then
    cp composer.json "$PLUGIN_DIR/"
    echo "  ✅ composer.json copied"
fi

# Handle Composer dependencies
if [ -f "composer.json" ]; then
    echo -e "${YELLOW}📦 Installing production dependencies...${NC}"
    
    # Install production dependencies
    composer install --no-dev --optimize-autoloader --no-interaction
    
    if [ $? -ne 0 ]; then
        echo -e "${RED}❌ Failed to install production dependencies${NC}"
        exit 1
    fi
    
    echo -e "${YELLOW}📦 Copying optimized vendor dependencies...${NC}"
    
    # Create vendor directory in temp
    mkdir -p "$PLUGIN_DIR/vendor"
    
    # Copy autoloader and composer files
    cp -r vendor/autoload.php "$PLUGIN_DIR/vendor/"
    cp -r vendor/composer/ "$PLUGIN_DIR/vendor/"
    echo "    ✅ Composer autoloader copied"
    
    # Copy silverassist packages (src/, assets/, composer.json only)
    if [ -d "vendor/silverassist" ]; then
        mkdir -p "$PLUGIN_DIR/vendor/silverassist"
        
        for package_dir in vendor/silverassist/*/; do
            if [ -d "$package_dir" ]; then
                package_name=$(basename "$package_dir")
                dest_dir="$PLUGIN_DIR/vendor/silverassist/$package_name"
                mkdir -p "$dest_dir"

                # Copy essential files only
                [ -f "$package_dir/composer.json" ] && cp "$package_dir/composer.json" "$dest_dir/"
                [ -d "$package_dir/src" ] && cp -r "$package_dir/src" "$dest_dir/"

                # Copy assets directory if it exists (CSS/JS required at runtime)
                if [ -d "$package_dir/assets" ]; then
                    cp -r "$package_dir/assets" "$dest_dir/"
                fi

                echo "    ✅ silverassist/$package_name copied"
            fi
        done
    fi
    
    echo -e "${YELLOW}📦 Restoring development dependencies for local environment...${NC}"
    # Restore development dependencies for local environment
    composer install --no-interaction > /dev/null 2>&1
fi

# Validate vendor package assets (CSS/JS required at runtime)
if [ -d "$PLUGIN_DIR/vendor" ]; then
    echo -e "${YELLOW}📦 Validating vendor package assets...${NC}"
    if [ ! -f "$PLUGIN_DIR/vendor/silverassist/wp-settings-hub/assets/css/settings-hub.css" ]; then
        echo -e "${RED}⚠️  Settings Hub CSS asset missing: vendor/silverassist/wp-settings-hub/assets/css/settings-hub.css${NC}"
    else
        echo "    ✅ Settings Hub CSS asset included"
    fi
    if [ ! -f "$PLUGIN_DIR/vendor/silverassist/wp-github-updater/assets/js/check-updates.js" ]; then
        echo -e "${RED}⚠️  GitHub updater JS asset missing: vendor/silverassist/wp-github-updater/assets/js/check-updates.js${NC}"
    else
        echo "    ✅ GitHub updater JS asset included"
    fi
fi

echo ""

# Create the ZIP file
echo -e "${YELLOW}🗜️  Creating ZIP archive...${NC}"
cd "$TEMP_DIR"
zip -r "$ZIP_NAME" leadgen-app-form/ -x "*.DS_Store*" "*.git*" "*node_modules*" "*.log*" "*.tmp*"

# Move ZIP to project root
mv "$ZIP_NAME" "$PROJECT_ROOT/"
cd "$PROJECT_ROOT"

# Clean up temp directory
rm -rf "$TEMP_DIR"

# Get ZIP size information
ZIP_SIZE=$(du -h "$ZIP_NAME" | cut -f1)
ZIP_SIZE_BYTES=$(stat -f%z "$ZIP_NAME" 2>/dev/null || stat -c%s "$ZIP_NAME" 2>/dev/null || echo "0")
ZIP_SIZE_KB=$((ZIP_SIZE_BYTES / 1024))

echo ""
echo -e "${GREEN}✅ Release ZIP created successfully!${NC}"
echo -e "${BLUE}📦 File: ${ZIP_NAME}${NC}"
echo -e "${BLUE}📏 Size: ${ZIP_SIZE} (~${ZIP_SIZE_KB}KB)${NC}"
echo ""
echo -e "${YELLOW}📂 Internal structure:${NC}"
echo "   leadgen-app-form/"
echo "   ├── leadgen-app-form.php"
echo "   ├── README.md"
echo "   ├── CHANGELOG.md"
echo "   ├── LICENSE"
echo "   ├── composer.json"
echo "   ├── vendor/"
echo "   │   ├── autoload.php"
echo "   │   ├── composer/"
echo "   │   └── silverassist/"
echo "   │       ├── wp-github-updater/"
echo "   │       └── wp-settings-hub/"
echo "   ├── includes/"
echo "   │   ├── class-leadgen-form-block.php"
echo "   │   ├── class-leadgen-app-form-updater.php"
echo "   │   ├── class-leadgen-app-form-admin.php"
echo "   │   └── elementor/"
echo "   ├── assets/"
echo "   │   ├── css/"
echo "   │   └── js/"
echo "   └── blocks/"
echo "       └── leadgen-form/"
echo ""
echo -e "${GREEN}🎉 Ready for WordPress installation!${NC}"
echo ""
echo -e "${BLUE}📋 Next steps:${NC}"
echo "1. Upload ${ZIP_NAME} to WordPress admin (Plugins → Add New → Upload Plugin)"
echo "2. The plugin folder will be extracted as 'leadgen-app-form' (without version)"
echo "3. WordPress will recognize it as a valid plugin"
echo "4. Activate and configure the plugin"
echo ""
echo -e "${CYAN}🔧 Development notes:${NC}"
echo "• ZIP filename includes version: ${ZIP_NAME}"
echo "• Internal folder name: leadgen-app-form (clean, no version)"
echo "• Size: ~${ZIP_SIZE_KB}KB"
echo "• Includes: Optimized vendor dependencies (production only)"
echo "• Excludes: .git, node_modules, development files"

# Output package information for GitHub Actions (if running in CI)
if [ -n "$GITHUB_OUTPUT" ]; then
    echo "package_name=leadgen-app-form-v${VERSION}" >> $GITHUB_OUTPUT
    echo "package_size=${ZIP_SIZE}" >> $GITHUB_OUTPUT
    echo "package_size_kb=${ZIP_SIZE_KB}KB" >> $GITHUB_OUTPUT
    echo "zip_path=${ZIP_NAME}" >> $GITHUB_OUTPUT
    echo "version=${VERSION}" >> $GITHUB_OUTPUT
fi
