#!/bin/bash

# LeadGen App Form Plugin - Package Size Calculator
# This script calculates the distribution package size locally

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_DIR="$(dirname "$SCRIPT_DIR")"

echo "🚀 LeadGen App Form Plugin - Package Size Calculator"
echo "=================================================="

# Change to project directory
cd "$PROJECT_DIR"

# Check if we're in the right directory
if [ ! -f "leadgen-app-form.php" ]; then
    echo "❌ Error: leadgen-app-form.php not found. Are you in the correct directory?"
    exit 1
fi

# Create temporary directory
TEMP_DIR=$(mktemp -d)
PACKAGE_NAME="leadgen-app-form-temp"

echo "📁 Creating temporary package..."

# Copy files excluding development files
rsync -av --exclude='.git*' \
          --exclude='.github/' \
          --exclude='scripts/' \
          --exclude='.eslintrc.json' \
          --exclude='.eslintignore' \
          --exclude='HEADER-STANDARDS.md' \
          --exclude='RELEASE-NOTES.md' \
          --exclude='RELEASE-PROCESS.md' \
          --exclude='QUICK-RELEASE.md' \
          --exclude='UPDATE-SYSTEM.md' \
          --exclude='composer.json' \
          --exclude='composer.lock' \
          --exclude='vendor/' \
          --exclude='node_modules/' \
          --exclude='*.tmp' \
          --exclude='*.log' \
          ./ "$TEMP_DIR/$PACKAGE_NAME/" > /dev/null

# Create ZIP file
cd "$TEMP_DIR"
zip -r "$PACKAGE_NAME.zip" "$PACKAGE_NAME/" > /dev/null

# Calculate sizes
PACKAGE_SIZE_HUMAN=$(ls -lh "$PACKAGE_NAME.zip" | awk '{print $5}')
PACKAGE_SIZE_BYTES=$(stat -c%s "$PACKAGE_NAME.zip" 2>/dev/null || stat -f%z "$PACKAGE_NAME.zip")
PACKAGE_SIZE_KB=$((PACKAGE_SIZE_BYTES / 1024))

echo "📦 Package Analysis:"
echo "   • ZIP file size: $PACKAGE_SIZE_HUMAN (~${PACKAGE_SIZE_KB}KB)"
echo "   • Uncompressed: $(du -sh "$PACKAGE_NAME" | cut -f1)"

# Count files
FILE_COUNT=$(find "$PACKAGE_NAME" -type f | wc -l)
echo "   • Total files: $FILE_COUNT"

# Show file breakdown
echo ""
echo "📋 File breakdown:"
echo "   • PHP files: $(find "$PACKAGE_NAME" -name "*.php" | wc -l)"
echo "   • JavaScript files: $(find "$PACKAGE_NAME" -name "*.js" | wc -l)"
echo "   • CSS files: $(find "$PACKAGE_NAME" -name "*.css" | wc -l)"
echo "   • JSON files: $(find "$PACKAGE_NAME" -name "*.json" | wc -l)"
echo "   • Documentation: $(find "$PACKAGE_NAME" -name "*.md" -o -name "*.txt" | wc -l)"

# Show largest files
echo ""
echo "📊 Largest files in package:"
find "$PACKAGE_NAME" -type f -exec ls -lh {} \; | sort -k5 -hr | head -5 | awk '{print "   • " $9 ": " $5}'

# Update RELEASE-NOTES.md if it exists (for development tracking)
if [ -f "$PROJECT_DIR/RELEASE-NOTES.md" ]; then
    echo ""
    echo "📝 Updating RELEASE-NOTES.md with current size (development file)..."
    
    # Get current version from plugin file
    CURRENT_VERSION=$(grep "Version:" "$PROJECT_DIR/leadgen-app-form.php" | head -1 | sed 's/.*Version: *//' | sed 's/ *$//')
    
    if [ -n "$CURRENT_VERSION" ]; then
        # Update the size line in RELEASE-NOTES.md
        if [[ "$OSTYPE" == "darwin"* ]]; then
            # macOS
            sed -i '' "s/- \*\*Size\*\*: ~[0-9]*KB/- **Size**: ~${PACKAGE_SIZE_KB}KB/" "$PROJECT_DIR/RELEASE-NOTES.md"
        else
            # Linux
            sed -i "s/- \*\*Size\*\*: ~[0-9]*KB/- **Size**: ~${PACKAGE_SIZE_KB}KB/" "$PROJECT_DIR/RELEASE-NOTES.md"
        fi
        echo "   ✅ Updated size to ~${PACKAGE_SIZE_KB}KB in RELEASE-NOTES.md (excluded from package)"
    else
        echo "   ⚠️  Could not determine current version from plugin file"
    fi
fi

# Cleanup
cd "$PROJECT_DIR"
rm -rf "$TEMP_DIR"

echo ""
echo "✅ Analysis complete!"
echo ""
echo "💡 Tips:"
echo "   • To reduce size, minimize large assets or split into separate downloads"
echo "   • Current size is excellent for a WordPress plugin"
echo "   • GitHub Actions will automatically calculate this on release"

exit 0
