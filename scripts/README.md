# Release Automation Documentation

## 🚀 Automated Release System

This system completely automates the release creation process for the LeadGen App Form Plugin, including automatic package size calculation.

## 📁 System Files

### GitHub Actions Workflows
- **`.github/workflows/release.yml`** - Main release workflow
- **`.github/workflows/check-size.yml`** - Package size verification for PRs

### Local Scripts
- **`scripts/calculate-size.sh`** - Local package size calculation
- **`scripts/update-version.sh`** - Automated version updating across all files
- **`scripts/check-versions.sh`** - Version consistency verification

## 🔄 Automated Workflow

### 1. Local Development

```bash
# Check current package size
./scripts/calculate-size.sh

# The script automatically updates RELEASE-NOTES.md with current size
```

### 2. Pull Requests

When you create a PR, GitHub Actions automatically:
- ✅ Calculates package size
- ✅ Comments on PR with current size
- ✅ Updates comment if you make more changes

### 3. Create Release

#### Option A: Using Git Tags (Recommended)
```bash
# 1. Update CHANGELOG.md with new version changes
# 2. Commit and push changes
git add .
git commit -m "Prepare release v1.0.1"
git push origin main

# 3. Create and push tag
git tag v1.0.1
git push origin v1.0.1

# 4. GitHub Actions automatically:
#    - Updates versions in all files
#    - Calculates package size
#    - Creates distribution ZIP
#    - Updates RELEASE-NOTES.md
#    - Creates GitHub Release
#    - Attaches package ZIP
```

#### Option B: Manual Release from GitHub
1. Go to GitHub → Actions → "Create Release Package"
2. Click "Run workflow"
3. Enter version (e.g., 1.0.1)
4. Click "Run workflow"

## 📦 What the Automation Does

### Automatic Version Updates
The system automatically updates the version in:
- `leadgen-app-form.php` (plugin header)
- All PHP files (`@version`)
- All CSS files (`@version`)
- All JavaScript files (`@version`)

### Size Calculation
- ✅ Excludes development files (`.eslintrc.json`, `.github/`, etc.)
- ✅ Creates optimized ZIP for distribution
- ✅ Calculates size in KB with precision
- ✅ Automatically updates `RELEASE-NOTES.md`

### Package Creation
- ✅ Includes only necessary files for distribution
- ✅ Names ZIP with version: `leadgen-app-form-v1.0.1.zip`
- ✅ Automatically attaches to GitHub Release

### Release Notes Generation
- ✅ Extracts changes from `CHANGELOG.md` for specific version
- ✅ Includes package information (size, installation)
- ✅ Adds installation instructions

## 🛠️ Archivos Incluidos/Excluidos

### ✅ Included in Distribution Package
```
leadgen-app-form.php
includes/
blocks/
assets/
README.md
CHANGELOG.md
LICENSE
```

### ❌ Excluded from Package
```
.git/
.github/
.eslintrc.json
.eslintignore
HEADER-STANDARDS.md
RELEASE-NOTES.md
scripts/
node_modules/
*.tmp, *.log
```

## 📊 Useful Local Commands

### Check Current Size
```bash
./scripts/calculate-size.sh
```

### Create Local Package for Testing
```bash
# Create temporary ZIP for testing
zip -r leadgen-app-form-test.zip . -x "*.git*" ".github/*" ".eslintrc.json" ".eslintignore" "HEADER-STANDARDS.md" "RELEASE-NOTES.md" "scripts/*"

# Check size
ls -lh leadgen-app-form-test.zip

# Clean up
rm leadgen-app-form-test.zip
```

### Verify Syntax Before Release
```bash
# PHP
php -l leadgen-app-form.php
find includes/ -name "*.php" -exec php -l {} \;

# JavaScript (if ESLint is installed)
npx eslint assets/js/ blocks/
```

## 🎯 Automation Benefits

### For the Developer
- 🚀 **1-click release** - Just create tag and everything is automated
- 📊 **Always updated size** - No more manual estimates
- 🔄 **Consistent versions** - Updates all files automatically
- 📋 **Automatic release notes** - Generated from CHANGELOG

### For Users
- 📦 **Optimized package** - Only necessary files
- 📏 **Accurate information** - Real download size
- 🔗 **Direct download** - ZIP attached to GitHub Release
- 📖 **Clear instructions** - Release notes with installation steps

### For Distribution
- 🏪 **Marketplace ready** - Standard package
- 📋 **Complete information** - Technical specifications
- 🔄 **Repeatable process** - Same flow for all versions

## 🔧 Emergency Configuration

If you need to create a release manually without automation:

```bash
# 1. Update versions manually in files
# 2. Create package
mkdir -p dist/leadgen-app-form-v1.0.1
rsync -av --exclude='.git*' --exclude='.github/' --exclude='.eslintrc.json' --exclude='.eslintignore' --exclude='HEADER-STANDARDS.md' --exclude='RELEASE-NOTES.md' ./ dist/leadgen-app-form-v1.0.1/
cd dist
zip -r leadgen-app-form-v1.0.1.zip leadgen-app-form-v1.0.1/

# 3. Upload manually to GitHub Releases
```

## � Version Management Scripts

### Check Current Versions

```bash
# Display version consistency report across all files
./scripts/check-versions.sh
```

**Output includes:**
- ✅ Main plugin file versions (header, constant, docblock)
- ✅ All PHP files (@version tags)
- ✅ All CSS files (@version tags)
- ✅ All JavaScript files (@version tags)
- ✅ Block metadata (block.json)
- ✅ Consistency warnings and errors

### Update All Versions

```bash
# Update version across all plugin files
./scripts/update-version.sh <new-version>

# Examples:
./scripts/update-version.sh 1.0.2    # Patch release
./scripts/update-version.sh 1.1.0    # Minor release
./scripts/update-version.sh 2.0.0    # Major release
```

**The script updates:**
- 📄 Main plugin file (header, constant, @version)
- 📄 All PHP files (@version tags)
- 📄 All CSS files (@version tags)
- 📄 All JavaScript files (@version tags)
- 📄 Block metadata files (block.json)

**Important Notes:**
- ⚠️ Script only updates `@version` tags, not `@since` tags
- ⚠️ New files need `@since` tag set manually
- ✅ Validates semantic version format
- ✅ Shows confirmation before making changes
- ✅ Provides next steps after completion

### Complete Release Workflow

```bash
# 1. Check current version consistency
./scripts/check-versions.sh

# 2. Update to new version
./scripts/update-version.sh 1.0.2

# 3. Review changes
git diff

# 4. Update CHANGELOG.md manually (add new version section)

# 5. Commit version update
git add .
git commit -m "🔧 Update version to 1.0.2"

# 6. Create tag and trigger automated release
git tag v1.0.2
git push origin main
git push origin v1.0.2
```

## �🚨 Troubleshooting

### If GitHub Actions Fails
1. Verify tag has format `v1.0.1`
2. Check GitHub Actions permissions
3. Review logs in GitHub → Actions

### If Size is Incorrect
1. Run `./scripts/calculate-size.sh` locally
2. Check excluded files in `.github/workflows/release.yml`
3. Verify there are no unwanted large files

With this system you'll never have to manually calculate package size again! 🎉
