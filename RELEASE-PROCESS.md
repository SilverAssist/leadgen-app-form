# Release Process Guide

## 📋 Complete Release Workflow

This document outlines the complete manual process for creating a new release of the LeadGen App Form Plugin.

## 🔄 Pre-Release Checklist

### 1. Version Planning
- [ ] Determine version number (follow [Semantic Versioning](https://semver.org/))
  - **Patch** (x.x.X): Bug fixes, small improvements
  - **Minor** (x.X.x): New features, backward compatible
  - **Major** (X.x.x): Breaking changes, major feature updates

### 2. Code Preparation
- [ ] All features/fixes are completed and tested
- [ ] Code is reviewed and approved
- [ ] All tests pass locally
- [ ] ESLint validation passes: `npx eslint assets/js/ blocks/`
- [ ] PHP syntax validation: `php -l leadgen-app-form.php`

## 📝 Manual Documentation Updates

### 3. Update CHANGELOG.md
**Location**: `/CHANGELOG.md`

Add new version section at the top (after line 7):

```markdown
## [NEW_VERSION] - YYYY-MM-DD

### Added
- New feature descriptions
- New functionality

### Enhanced
- Improvements to existing features
- Performance optimizations

### Fixed
- Bug fixes
- Issue resolutions

### Changed
- Breaking changes (if any)
- Modified behaviors

### Removed
- Deprecated features
- Removed functionality
```

**Example**:
```markdown
## [1.0.3] - 2025-07-30

### Added
- New form validation system
- Enhanced error handling for mobile devices

### Fixed
- Fixed form loading issue on Safari browsers
- Resolved CSS conflicts with certain themes
```

### 4. Update README.md
**Location**: `/README.md`

Update the following sections:

#### Version References
- [ ] **Line ~15**: Plugin version in installation instructions
- [ ] **Requirements section**: Verify WordPress/PHP version requirements
- [ ] **Version History**: Add brief mention of new version if significant

#### Installation Instructions
- [ ] Update download links if changed
- [ ] Verify installation steps are current
- [ ] Update any new configuration requirements

#### Feature Documentation
- [ ] Document new features added in this version
- [ ] Update screenshots if UI changed
- [ ] Update configuration examples

### 5. Pre-Update RELEASE-NOTES.md
**Location**: `/RELEASE-NOTES.md`

The GitHub Actions workflow will automatically generate this, but you can preview what it should contain:

- [ ] Version number and release date
- [ ] Package size (~38KB typically)
- [ ] Installation instructions
- [ ] Feature highlights

## 🚀 Release Execution

### 6. Version Update Process

#### Option A: Automated Script (Recommended)
```bash
# Use the automated version update script
./scripts/update-version-simple.sh NEW_VERSION

# Example:
./scripts/update-version-simple.sh 1.0.3
```

#### Option B: Manual Version Updates
If automated script fails, update manually:

**Files to update** (replace `OLD_VERSION` with `NEW_VERSION`):
- [ ] `leadgen-app-form.php` (Line ~4): `Version: NEW_VERSION`
- [ ] `leadgen-app-form.php` (@version): `@version NEW_VERSION`
- [ ] `includes/*.php` (@version): `@version NEW_VERSION`
- [ ] `assets/css/*.css` (@version): `@version NEW_VERSION`
- [ ] `assets/js/*.js` (@version): `@version NEW_VERSION`
- [ ] `blocks/**/*.js` (@version): `@version NEW_VERSION`

### 7. Verify Version Consistency
```bash
# Check all versions are consistent
./scripts/check-versions.sh
```

### 8. Commit Documentation Changes
```bash
# Commit documentation updates first
git add CHANGELOG.md README.md
git commit -m "📚 Update documentation for v1.0.3 release"
git push origin main
```

### 9. Create Release Tag
```bash
# Create and push the release tag
git tag v1.0.3
git push origin v1.0.3
```

## 🤖 Automated Release Process

### 10. GitHub Actions Execution
After pushing the tag, GitHub Actions will automatically:

- [ ] ✅ Update version numbers in all files
- [ ] ✅ Extract changes from CHANGELOG.md
- [ ] ✅ Generate RELEASE-NOTES.md
- [ ] ✅ Create distribution package (~38KB)
- [ ] ✅ Create GitHub Release with download links
- [ ] ✅ Upload package artifacts

### 11. Monitor Release Process
- [ ] Check [GitHub Actions](https://github.com/SilverAssist/leadgen-app-form/actions)
- [ ] Verify release appears in [Releases](https://github.com/SilverAssist/leadgen-app-form/releases)
- [ ] Test download and installation of release package

## 🎯 Post-Release Verification

### 12. Release Validation
- [ ] Download the release ZIP file
- [ ] Test installation in WordPress environment
- [ ] Verify all features work correctly
- [ ] Check plugin activation/deactivation
- [ ] Test both Gutenberg and Elementor integrations

### 13. Documentation Updates (if needed)
- [ ] Update any external documentation
- [ ] Announce release if significant
- [ ] Update development roadmap

## 🚨 Troubleshooting

### Common Issues

#### GitHub Actions Fails
- Check workflow logs for specific errors
- Verify CHANGELOG.md format is correct
- Ensure all required files exist

#### Version Inconsistencies
- Run `./scripts/check-versions.sh` to identify issues
- Use `./scripts/update-version-simple.sh` to fix

#### CHANGELOG Parsing Issues
- Ensure version format: `## [1.0.3] - 2025-07-30`
- Check for proper markdown formatting
- Verify section headers (### Added, ### Fixed, etc.)

## 📋 Release Checklist Template

Copy this checklist for each release:

```
Release v_____ Checklist:

Pre-Release:
- [ ] Version number determined
- [ ] All features/fixes completed
- [ ] Code reviewed and tested
- [ ] CHANGELOG.md updated
- [ ] README.md updated (if needed)

Release Process:
- [ ] Version updated (script or manual)
- [ ] Version consistency verified
- [ ] Documentation committed
- [ ] Release tag created and pushed

Post-Release:
- [ ] GitHub Actions completed successfully
- [ ] Release created and available
- [ ] Package downloaded and tested
- [ ] Installation verified
```

## 📚 Additional Resources

- [Semantic Versioning Guide](https://semver.org/)
- [Keep a Changelog Format](https://keepachangelog.com/)
- [GitHub Releases Documentation](https://docs.github.com/en/repositories/releasing-projects-on-github)
- [WordPress Plugin Development](https://developer.wordpress.org/plugins/)

---

**💡 Tip**: Bookmark this document and follow it step-by-step for each release to ensure consistency and prevent missing critical steps.
