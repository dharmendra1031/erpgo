#!/usr/bin/env python3
import pathlib
import re
import sys

ROOT = pathlib.Path(__file__).resolve().parents[1]
ROUTES = ROOT / "routes"
CONTROLLERS = ROOT / "app" / "Http" / "Controllers"

action_re = re.compile(r"['\"]([A-Za-z0-9_\\]+Controller)@([A-Za-z0-9_]+)['\"]")
method_re = re.compile(r"\bfunction\s+([A-Za-z_][A-Za-z0-9_]*)\s*\(")

errors = []
checked = set()

for route_file in sorted(ROUTES.glob("*.php")):
    text = route_file.read_text(encoding="utf-8", errors="ignore")
    for controller, method in action_re.findall(text):
        key = (controller, method)
        if key in checked:
            continue
        checked.add(key)

        relative = pathlib.Path(*controller.split("\\"))
        controller_file = CONTROLLERS / relative.with_suffix(".php")
        if not controller_file.exists():
            errors.append(f"MISSING CONTROLLER: {controller}@{method} -> {controller_file.relative_to(ROOT)}")
            continue

        controller_text = controller_file.read_text(encoding="utf-8", errors="ignore")
        methods = set(method_re.findall(controller_text))
        if method not in methods:
            errors.append(f"MISSING METHOD: {controller}@{method} -> {controller_file.relative_to(ROOT)}")

print(f"Checked {len(checked)} unique controller actions.")
if errors:
    print("\n".join(errors))
    sys.exit(1)

print("All string-style route controller actions resolve to existing methods.")
