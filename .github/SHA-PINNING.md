# GitHub Actions SHA Pinning - Implementation Documentation

## Overview

This document describes the SHA pinning implementation for GitHub Actions in the LeadGen App Form Plugin repository. SHA pinning enhances security by preventing tag mutation attacks while maintaining easy updates through Dependabot automation.

## What is SHA Pinning?

SHA pinning replaces mutable Git tags (like `v4`, `v2`) with immutable commit SHAs. This prevents malicious actors from modifying the code behind a tag after it has been published.

### Before SHA Pinning (Vulnerable)
```yaml
- uses: actions/checkout@v4  # Tag can be changed to point to different code
```

### After SHA Pinning (Secure)
```yaml
- uses: actions/checkout@11bd71901bbe5b1630ceea73d27597364c9af683 # v4.2.2
```

## Implementation Details

### Actions Pinned

All GitHub Actions used in this repository have been pinned to specific commit SHAs:

| Action | Original Tag | Pinned SHA | Version | Workflow Files |
|--------|-------------|------------|---------|----------------|
| `actions/checkout` | `@v4` | `11bd71901bbe5b1630ceea73d27597364c9af683` | v4.2.2 | All workflows (5 occurrences) |
| `shivammathur/setup-php` | `@v2` | `e30be03c360f860e4887a66a9e06c3c88812118c` | v2.31.1 | quality-checks.yml (3 occurrences) |
| `softprops/action-gh-release` | `@v1` | `69320dbe05506a9a39fc8ae11030b214ec2d1f87` | v1.0.0 | release.yml |
| `actions/upload-artifact` | `@v4` | `b4b15b8a3f9cc9c8cf4a19c2dd8b63ccbac371af` | v4.4.3 | release.yml |
| `actions/github-script` | `@v6` | `60a0d83039c74a4aee543508d2ffcb1c3799cdea` | v6.4.1 | check-size.yml |

### Workflow Files Modified

1. **`.github/workflows/quality-checks.yml`**
   - 3 instances of `actions/checkout@v4` pinned
   - 3 instances of `shivammathur/setup-php@v2` pinned

2. **`.github/workflows/release.yml`**
   - 1 instance of `actions/checkout@v4` pinned
   - 1 instance of `softprops/action-gh-release@v1` pinned
   - 1 instance of `actions/upload-artifact@v4` pinned

3. **`.github/workflows/check-size.yml`**
   - 1 instance of `actions/checkout@v4` pinned
   - 1 instance of `actions/github-script@v6` pinned

## Automated Updates with Dependabot

### Dependabot Configuration

A new `.github/dependabot.yml` file has been created to automate SHA updates:

```yaml
version: 2
updates:
  - package-ecosystem: "github-actions"
    directory: "/"
    schedule:
      interval: "weekly"
      day: "monday"
      time: "09:00"
      timezone: "America/Mexico_City"
```

### Features

- **Weekly Updates**: Checks every Monday at 9:00 AM (Mexico City timezone)
- **Grouped Updates**: All GitHub Actions updates are grouped into a single PR
- **Automatic Labeling**: PRs are labeled with `dependencies`, `github-actions`, and `automated`
- **Version Protection**: Major version updates require manual review
- **SHA Recognition**: Dependabot automatically recognizes SHA-pinned actions and updates them

### How Dependabot Works with SHA Pinning

1. Dependabot scans the version comments (e.g., `# v4.2.2`)
2. Checks for new versions of the action
3. Creates a PR with updated SHA + version comment
4. Groups minor/patch updates together for efficiency

### Manual Review for Major Updates

The following actions are configured to require manual review for major version updates:
- `actions/checkout` (e.g., v4.x → v5.x)
- `shivammathur/setup-php` (e.g., v2.x → v3.x)
- `actions/upload-artifact` (e.g., v4.x → v5.x)
- `actions/github-script` (e.g., v6.x → v7.x)

## Security Benefits

### 1. Prevents Tag Mutation Attacks

**Vulnerability**: Attackers can force-push to existing tags, changing the code that runs in workflows.

**Solution**: SHA pinning makes actions immutable. Once pinned, the exact code version is locked.

### 2. Resolves Code Scanning Alerts

GitHub's CodeQL and security scanners flag unpinned actions as a security risk. This implementation resolves those alerts.

### 3. Audit Trail

Version comments (e.g., `# v4.2.2`) provide a human-readable audit trail while maintaining security.

### 4. Controlled Updates

Major version updates require manual review, preventing breaking changes from automatically being introduced.

## Verification

### Verify No Unpinned Actions

```bash
# Should return empty (all actions are pinned)
grep -r "uses:" .github/workflows/ | grep -v "#" | grep "@v"
```

### Verify All Actions Have SHA Comments

```bash
# Should show all actions with SHA + version
grep -r "uses:" .github/workflows/ | grep "#"
```

### Validate YAML Syntax

```bash
for file in .github/workflows/*.yml; do
  echo "Checking $file..."
  python3 -c "import yaml; yaml.safe_load(open('$file'))"
done
```

## Maintenance

### When Actions Release New Versions

1. **Minor/Patch Updates**: Dependabot automatically creates PRs
2. **Major Updates**: Manual review required
   - Check CHANGELOG for breaking changes
   - Update workflows if needed
   - Approve and merge Dependabot PR

### Manual SHA Update Process

If you need to update an action manually:

1. Find the latest release tag (e.g., `v4.2.3`)
2. Get the commit SHA:
   ```bash
   gh api /repos/actions/checkout/commits/v4.2.3 --jq '.sha'
   ```
3. Update the workflow file:
   ```yaml
   uses: actions/checkout@<new-sha> # v4.2.3
   ```

### Adding New Actions

When adding a new GitHub Action to workflows:

1. **DO NOT** use mutable tags:
   ```yaml
   # ❌ WRONG
   uses: actions/setup-node@v4
   ```

2. **DO** use SHA pinning with version comment:
   ```yaml
   # ✅ CORRECT
   uses: actions/setup-node@<full-sha> # v4.x.x
   ```

3. Get the SHA using:
   ```bash
   gh api /repos/actions/setup-node/commits/v4 --jq '.sha'
   ```

## Troubleshooting

### Dependabot Not Creating PRs

**Check**: Is Dependabot enabled in repository settings?
1. Go to Settings → Code security and analysis
2. Enable "Dependabot alerts"
3. Enable "Dependabot security updates"
4. Enable "Dependabot version updates"

### Action Fails with "Invalid Ref"

**Cause**: SHA is incorrect or has been deleted

**Solution**: Verify the SHA exists in the action's repository
```bash
gh api /repos/actions/checkout/commits/<sha>
```

### Version Comment Mismatch

**Symptom**: Comment shows v4.2.2 but newer v4.2.3 is available

**Expected**: Dependabot will create a PR to update both SHA and comment

## References

- [GitHub Actions Security Hardening](https://docs.github.com/en/actions/security-guides/security-hardening-for-github-actions)
- [Dependabot Configuration](https://docs.github.com/en/code-security/dependabot/dependabot-version-updates/configuration-options-for-the-dependabot.yml-file)
- [GitHub API - Get Commit](https://docs.github.com/en/rest/commits/commits#get-a-commit)

## Implementation Date

**Implemented**: November 14, 2025  
**Last Updated**: November 14, 2025  
**Next Review**: When Dependabot creates update PRs

---

**Note**: This implementation follows GitHub security best practices and resolves code scanning alerts related to unpinned actions.
