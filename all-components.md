# shadcn vs. LaralCN-UI — Component Coverage

Comparison of every component listed at [ui.shadcn.com/docs/components](https://ui.shadcn.com/docs/components)
against what LaralCN-UI currently ships in `registry/components/`.

**Coverage: 25 / 60 shadcn entries.** (Several shadcn "entries" are guides/providers,
not real components — see notes.) Plus the first **block**, `sidebar-01`, assembled
from these components — see [`/blocks`](./website) on the site.

Legend: ✅ have it · ⚠️ partial / different flavor · ❌ not yet

| #   | shadcn component | Have it? | LaralCN-UI name | Notes                                                                    |
| --- | ---------------- | -------- | --------------- | ------------------------------------------------------------------------ |
| 1   | Accordion        | ✅       | `accordion`     |                                                                          |
| 2   | Alert            | ✅       | `alert`         |                                                                          |
| 3   | Alert Dialog     | ❌       | —               | We have `dialog`, not the confirm-style alert dialog                     |
| 4   | Aspect Ratio     | ❌       | —               |                                                                          |
| 5   | Avatar           | ✅       | `avatar`        |                                                                          |
| 6   | Badge            | ✅       | `badge`         |                                                                          |
| 7   | Breadcrumb       | ✅       | `breadcrumb`    | 7 namespaced parts (list/item/link/page/separator/ellipsis)              |
| 8   | Button           | ✅       | `button`        |                                                                          |
| 9   | Button Group     | ❌       | —               |                                                                          |
| 10  | Calendar         | ❌       | —               |                                                                          |
| 11  | Card             | ✅       | `card`          |                                                                          |
| 12  | Carousel         | ❌       | —               |                                                                          |
| 13  | Chart            | ❌       | —               |                                                                          |
| 14  | Checkbox         | ✅       | `checkbox`      | Native `<input type=checkbox>` styled to match                           |
| 15  | Collapsible      | ✅       | `collapsible`   | Alpine + @alpinejs/collapse; namespaced (index/trigger/content)          |
| 16  | Combobox         | ❌       | —               |                                                                          |
| 17  | Command          | ❌       | —               |                                                                          |
| 18  | Context Menu     | ❌       | —               | We have `dropdown-menu` (click), not right-click context menu            |
| 19  | Data Table       | ❌       | —               | We have a basic `table`, not the sortable/filterable data table          |
| 20  | Date Picker      | ❌       | —               |                                                                          |
| 21  | Dialog           | ✅       | `dialog`        |                                                                          |
| 22  | Direction        | ❌       | —               | Not a component (RTL provider doc)                                       |
| 23  | Drawer           | ❌       | —               |                                                                          |
| 24  | Dropdown Menu    | ✅       | `dropdown-menu` |                                                                          |
| 25  | Empty            | ❌       | —               |                                                                          |
| 26  | Field            | ❌       | —               |                                                                          |
| 27  | Hover Card       | ❌       | —               |                                                                          |
| 28  | Input            | ✅       | `input`         |                                                                          |
| 29  | Input Group      | ❌       | —               |                                                                          |
| 30  | Input OTP        | ❌       | —               |                                                                          |
| 31  | Item             | ❌       | —               |                                                                          |
| 32  | Kbd              | ❌       | —               |                                                                          |
| 33  | Label            | ✅       | `label`         |                                                                          |
| 34  | Menubar          | ❌       | —               |                                                                          |
| 35  | Native Select    | ✅       | `select`        | Our `select` IS the native-select flavor                                 |
| 36  | Navigation Menu  | ❌       | —               |                                                                          |
| 37  | Pagination       | ❌       | —               |                                                                          |
| 38  | Popover          | ❌       | —               |                                                                          |
| 39  | Progress         | ❌       | —               |                                                                          |
| 40  | Radio Group      | ✅       | `radio`         | Native `<input type=radio>` styled to match                              |
| 41  | Resizable        | ❌       | —               |                                                                          |
| 42  | Scroll Area      | ❌       | —               |                                                                          |
| 43  | Select           | ⚠️       | `select`        | We ship the **native** select, not the Radix popover/combobox select     |
| 44  | Separator        | ✅       | `separator`     |                                                                          |
| 45  | Sheet            | ✅       | `sheet`         | Off-canvas overlay; `side=top\|right\|bottom\|left`, Alpine x-trap       |
| 46  | Sidebar          | ✅       | `sidebar`       | 22-part compound: icon-collapse, mobile off-canvas, cookie + Ctrl/Cmd-B  |
| 47  | Skeleton         | ✅       | `skeleton`      | Loading placeholder                                                      |
| 48  | Slider           | ❌       | —               |                                                                          |
| 49  | Sonner           | ⚠️       | `toast`         | Our `toast` is Sonner-style; shadcn now favors Sonner over the old Toast |
| 50  | Spinner          | ❌       | —               |                                                                          |
| 51  | Switch           | ✅       | `switch`        |                                                                          |
| 52  | Table            | ✅       | `table`         | Basic table (not Data Table)                                             |
| 53  | Tabs             | ✅       | `tabs`          |                                                                          |
| 54  | Textarea         | ✅       | `textarea`      |                                                                          |
| 55  | Toast            | ✅       | `toast`         | Deprecated upstream in favor of Sonner, but still listed                 |
| 56  | Toggle           | ❌       | —               |                                                                          |
| 57  | Toggle Group     | ❌       | —               |                                                                          |
| 58  | Tooltip          | ✅       | `tooltip`       |                                                                          |
| 59  | Typography       | ❌       | —               | Not a component (styling guide)                                          |

## What we have (25)

`accordion`, `alert`, `avatar`, `badge`, `breadcrumb`, `button`, `card`, `checkbox`,
`collapsible`, `dialog`, `dropdown-menu`, `input`, `label`, `radio`, `select`,
`separator`, `sheet`, `sidebar`, `skeleton`, `switch`, `table`, `tabs`, `textarea`,
`toast`, `tooltip`

## Blocks (1)

- **`sidebar-01`** — application shell composed from `sidebar`, `breadcrumb`,
  `collapsible`, `dropdown-menu`, `avatar`, `separator`, `button`, `skeleton`.
  Browse it on the site's **Blocks** page (`/blocks`).

## Missing (high-value candidates to add next)

- **Overlays:** Alert Dialog, Drawer, Popover, Hover Card, Context Menu
- **Forms/inputs:** Combobox, Input OTP, Input Group, Slider, Toggle, Toggle Group, Date Picker, Calendar
- **Navigation:** Pagination, Navigation Menu, Menubar, Command
- **Feedback/display:** Progress, Spinner, Empty, Aspect Ratio, Scroll Area, Resizable, Carousel, Chart, Data Table

> Notes: **Direction** and **Typography** are docs/guides upstream, not installable
> components. **Select** is counted as a "have" only in its native flavor (it covers
> shadcn's _Native Select_); the Radix popover _Select_ is not yet implemented.
