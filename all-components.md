# shadcn vs. LaralCN-UI — Component Coverage

Comparison of every component listed at [ui.shadcn.com/docs/components](https://ui.shadcn.com/docs/components)
against what LaralCN-UI currently ships in `registry/components/`.

**Coverage: 35 / 59 shadcn entries.** (Several shadcn "entries" are guides/providers,
not real components — see notes.) Plus 7 **blocks** assembled from these components —
see [`/blocks`](./website) on the site.

Legend: ✅ have it · ⚠️ partial / different flavor · ❌ not yet

| #   | shadcn component | Have it? | LaralCN-UI name | Notes                                                                    |
| --- | ---------------- | -------- | --------------- | ------------------------------------------------------------------------ |
| 1   | Accordion        | ✅       | `accordion`     |                                                                          |
| 2   | Alert            | ✅       | `alert`         |                                                                          |
| 3   | Alert Dialog     | ✅       | `alert-dialog`  | Confirm-style modal with cancel / action footer                          |
| 4   | Aspect Ratio     | ✅       | `aspect-ratio`  | Holds children to a fixed width-to-height ratio                          |
| 5   | Avatar           | ✅       | `avatar`        |                                                                          |
| 6   | Badge            | ✅       | `badge`         |                                                                          |
| 7   | Breadcrumb       | ✅       | `breadcrumb`    | 7 namespaced parts (list/item/link/page/separator/ellipsis)              |
| 8   | Button           | ✅       | `button`        |                                                                          |
| 9   | Button Group     | ❌       | —               |                                                                          |
| 10  | Calendar         | ❌       | —               |                                                                          |
| 11  | Card             | ✅       | `card`          |                                                                          |
| 12  | Carousel         | ✅       | `carousel`      | CSS scroll-snap slides with arrow controls                               |
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
| 27  | Hover Card       | ✅       | `hover-card`    | Preview card on hover or focus                                           |
| 28  | Input            | ✅       | `input`         |                                                                          |
| 29  | Input Group      | ❌       | —               |                                                                          |
| 30  | Input OTP        | ❌       | —               |                                                                          |
| 31  | Item             | ❌       | —               |                                                                          |
| 32  | Kbd              | ❌       | —               |                                                                          |
| 33  | Label            | ✅       | `label`         |                                                                          |
| 34  | Menubar          | ❌       | —               |                                                                          |
| 35  | Native Select    | ✅       | `select`        | Our `select` IS the native-select flavor                                 |
| 36  | Navigation Menu  | ❌       | —               |                                                                          |
| 37  | Pagination       | ✅       | `pagination`    | Previous / next, numbered links, ellipsis                                |
| 38  | Popover          | ❌       | —               |                                                                          |
| 39  | Progress         | ✅       | `progress`      |                                                                          |
| 40  | Radio Group      | ✅       | `radio`         | Native `<input type=radio>` styled to match                              |
| 41  | Resizable        | ❌       | —               |                                                                          |
| 42  | Scroll Area      | ✅       | `scroll-area`   | Themed scrollbar on a native scroll container                            |
| 43  | Select           | ⚠️       | `select`        | We ship the **native** select, not the Radix popover/combobox select     |
| 44  | Separator        | ✅       | `separator`     |                                                                          |
| 45  | Sheet            | ✅       | `sheet`         | Off-canvas overlay; `side=top\|right\|bottom\|left`, Alpine x-trap       |
| 46  | Sidebar          | ✅       | `sidebar`       | 22-part compound: icon-collapse, mobile off-canvas, cookie + Ctrl/Cmd-B  |
| 47  | Skeleton         | ✅       | `skeleton`      | Loading placeholder                                                      |
| 48  | Slider           | ✅       | `slider`        | Native `<input type=range>`, submits with the form                       |
| 49  | Sonner           | ⚠️       | `toast`         | Our `toast` is Sonner-style; shadcn now favors Sonner over the old Toast |
| 50  | Spinner          | ❌       | —               |                                                                          |
| 51  | Switch           | ✅       | `switch`        |                                                                          |
| 52  | Table            | ✅       | `table`         | Basic table (not Data Table)                                             |
| 53  | Tabs             | ✅       | `tabs`          |                                                                          |
| 54  | Textarea         | ✅       | `textarea`      |                                                                          |
| 55  | Toast            | ✅       | `toast`         | Deprecated upstream in favor of Sonner, but still listed                 |
| 56  | Toggle           | ✅       | `toggle`        | Native checkbox under a button skin, submits with the form               |
| 57  | Toggle Group     | ✅       | `toggle-group`  | Joined toggles, single or multiple selection                             |
| 58  | Tooltip          | ✅       | `tooltip`       |                                                                          |
| 59  | Typography       | ❌       | —               | Not a component (styling guide)                                          |

## What we have (35)

`accordion`, `alert`, `alert-dialog`, `aspect-ratio`, `avatar`, `badge`, `breadcrumb`,
`button`, `card`, `carousel`, `checkbox`, `collapsible`, `dialog`, `dropdown-menu`,
`hover-card`, `input`, `label`, `pagination`, `progress`, `radio`, `scroll-area`,
`select`, `separator`, `sheet`, `sidebar`, `skeleton`, `slider`, `switch`, `table`,
`tabs`, `textarea`, `toast`, `toggle`, `toggle-group`, `tooltip`

## Blocks (7)

- **`sidebar-01`** — application shell with workspace switcher, nav groups, and a
  user footer. Ctrl/Cmd-B toggles it.
- **`navbar-01`** — centered links, a dropdown, dual call-to-action buttons.
- **`navbar-02`** — the same, trimmed to a single primary action.
- **`navbar-03`** — full-width mega menu: two link columns plus a featured panel.
- **`navbar-04`** — mega menu as a two-column grid of icon / title / description.
- **`navbar-05`** — compact two-group mega menu with a footer CTA row.
- **`navbar-06`** — floating pill navbar detached from the top edge.

Every navbar collapses into a slide-in sheet on mobile. Browse them on the site's
**Blocks** page (`/blocks`).

## Missing (high-value candidates to add next)

- **Overlays:** Drawer, Popover, Context Menu
- **Forms/inputs:** Combobox, Input OTP, Input Group, Field, Date Picker, Calendar, Button Group
- **Navigation:** Navigation Menu, Menubar, Command
- **Feedback/display:** Spinner, Empty, Item, Kbd, Resizable, Chart, Data Table

> Notes: **Direction** and **Typography** are docs/guides upstream, not installable
> components. **Select** is counted as a "have" only in its native flavor (it covers
> shadcn's _Native Select_); the Radix popover _Select_ is not yet implemented.
