#!/usr/bin/env python3
"""Build a clean, uploadable WordPress plugin ZIP."""

import os
import sys
import zipfile
from pathlib import Path

# Configuration
PLUGIN_NAME = "divine-homepage-redesign"
EXPECTED_MAIN_FILE = f"{PLUGIN_NAME}/{PLUGIN_NAME}.php"
EXCLUDES = {
    ".git",
    ".github",
    "dist",
    "__pycache__",
    ".DS_Store",
    ".vscode",
    "node_modules",
}
EXCLUDE_EXTENSIONS = {".zip"}


def should_exclude(rel_path: str) -> bool:
    """Return True if the relative path should be excluded from the ZIP."""
    parts = Path(rel_path).parts
    for part in parts:
        if part in EXCLUDES:
            return True
        if part.startswith(".") and part in EXCLUDES:
            return True
    if Path(rel_path).suffix in EXCLUDE_EXTENSIONS:
        return True
    return False


def main() -> int:
    # Determine repo root (parent of tools/ directory)
    script_dir = Path(__file__).resolve().parent
    repo_root = script_dir.parent
    dist_dir = repo_root / "dist"
    dist_dir.mkdir(exist_ok=True)

    main_plugin_file = repo_root / f"{PLUGIN_NAME}.php"
    if not main_plugin_file.is_file():
        print(f"ERROR: Missing required file: {main_plugin_file}", file=sys.stderr)
        return 1

    zip_path = dist_dir / f"{PLUGIN_NAME}.zip"

    # Build ZIP
    with zipfile.ZipFile(zip_path, "w", zipfile.ZIP_DEFLATED) as zf:
        for root, dirs, files in os.walk(repo_root):
            # Prune excluded directories in-place to avoid descending into them
            dirs[:] = [d for d in dirs if d not in EXCLUDES]

            for file in files:
                abs_path = Path(root) / file
                rel_path = abs_path.relative_to(repo_root).as_posix()

                if should_exclude(rel_path):
                    continue

                arcname = f"{PLUGIN_NAME}/{rel_path}"

                # Validation: no backslashes in ZIP paths
                if "\\" in arcname:
                    print(f"ERROR: ZIP path contains backslash: {arcname!r}", file=sys.stderr)
                    return 1

                # Validation: no nested duplicate folder paths
                dup_marker = f"{PLUGIN_NAME}/{PLUGIN_NAME}/"
                if dup_marker in arcname:
                    print(f"ERROR: Nested duplicate folder path detected: {arcname!r}", file=sys.stderr)
                    return 1

                zf.write(str(abs_path), arcname)

    # Post-build validation
    with zipfile.ZipFile(zip_path, "r") as zf:
        namelist = zf.namelist()

        if EXPECTED_MAIN_FILE not in namelist:
            print(
                f"ERROR: ZIP missing required entry: {EXPECTED_MAIN_FILE}", file=sys.stderr
            )
            return 1

        print(f"ZIP path : {zip_path}")
        print(f"File count: {len(namelist)}")
        print("First 30 entries:")
        for entry in namelist[:30]:
            print(f"  {entry}")

        print("PACKAGE OK")

    return 0


if __name__ == "__main__":
    sys.exit(main())
