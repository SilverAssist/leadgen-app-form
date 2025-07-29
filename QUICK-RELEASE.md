# Quick Release Reference

## 🚀 Release Checklist (Copy for each release)

**Release Version**: `v_____`
**Release Date**: `_____`

### Pre-Release Tasks
- [ ] **Determine version number** (patch/minor/major)
- [ ] **Complete all development work**
- [ ] **Test functionality** locally
- [ ] **Run linting**: `npx eslint assets/js/ blocks/`
- [ ] **Check PHP syntax**: `php -l leadgen-app-form.php`

### Documentation Updates
- [ ] **Update CHANGELOG.md**
  - Add new version section: `## [X.X.X] - YYYY-MM-DD`
  - Document all changes (Added/Enhanced/Fixed/Changed/Removed)
- [ ] **Update README.md** (if features changed)
  - Version references
  - New feature documentation
  - Installation instructions (if changed)

### Version Management
- [ ] **Run version update**: `./scripts/update-version-simple.sh X.X.X`
- [ ] **Verify consistency**: `./scripts/check-versions.sh`
- [ ] **Review changes**: `git diff`

### Release Execution
- [ ] **Commit documentation**: 
  ```bash
  git add CHANGELOG.md README.md
  git commit -m "📚 Update documentation for vX.X.X release"
  git push origin main
  ```
- [ ] **Create and push tag**:
  ```bash
  git tag vX.X.X
  git push origin vX.X.X
  ```

### Post-Release Verification
- [ ] **Monitor GitHub Actions**: [Actions](https://github.com/SilverAssist/leadgen-app-form/actions)
- [ ] **Verify release created**: [Releases](https://github.com/SilverAssist/leadgen-app-form/releases)
- [ ] **Download and test** the ZIP file
- [ ] **Test installation** in WordPress

---

## 📋 Common Version Patterns

### Patch Release (Bug fixes)
- `1.0.2` → `1.0.3`
- **CHANGELOG sections**: Primarily `### Fixed`
- **README updates**: Usually not needed

### Minor Release (New features)
- `1.0.2` → `1.1.0`
- **CHANGELOG sections**: `### Added`, `### Enhanced`
- **README updates**: Document new features

### Major Release (Breaking changes)
- `1.0.2` → `2.0.0`
- **CHANGELOG sections**: `### Changed`, `### Removed`
- **README updates**: Update requirements, breaking changes

## 🛠️ Emergency Commands

### If Version Update Fails
```bash
# Manual version check
grep -r "1\.0\.2" . --exclude-dir=.git --exclude-dir=node_modules

# Manual version update (last resort)
find . -name "*.php" -not -path "./.git/*" -exec sed -i 's/@version 1\.0\.2/@version 1.0.3/g' {} \;
```

### If Tag Already Exists
```bash
# Delete and recreate tag
git tag -d vX.X.X
git push --delete origin vX.X.X
git tag vX.X.X
git push origin vX.X.X
```

### If GitHub Actions Fails
- Check workflow logs for specific errors
- Verify CHANGELOG.md format: `## [X.X.X] - YYYY-MM-DD`
- Ensure all required files exist
- Check for syntax errors in workflow YAML

## 📝 CHANGELOG Format Template

```markdown
## [X.X.X] - YYYY-MM-DD

### Added
- New feature or functionality
- New files or components

### Enhanced
- Improvements to existing features
- Performance optimizations
- Better error handling

### Fixed
- Bug fixes
- Issue resolutions
- Security patches

### Changed
- Breaking changes
- Modified behaviors
- Updated dependencies

### Removed
- Deprecated features
- Removed files or functionality
```

---

**💡 Tip**: Keep this file open during release process and check off items as you complete them.
