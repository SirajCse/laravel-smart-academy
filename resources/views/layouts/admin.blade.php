<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if($isRtl ?? false) dir="rtl" @endif class="@if(session('theme') === 'dark') dark @endif">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $schoolName ?? config('app.name'))</title>

    {{-- Tailwind + app CSS (built by Vite) --}}
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        {{-- Fallback: CDN Tailwind (for first run before npm build) --}}
        <script src="https://cdn.tailwindcss.com/3.4.16"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            border: 'hsl(214.3 31.8% 91.4%)',
                            input: 'hsl(214.3 31.8% 91.4%)',
                            ring: 'hsl(222.2 84% 4.9%)',
                            background: 'hsl(0 0% 100%)',
                            foreground: 'hsl(222.2 84% 4.9%)',
                            primary: { DEFAULT: 'hsl(222.2 47.4% 11.2%)', foreground: 'hsl(210 40% 98%)' },
                            secondary: { DEFAULT: 'hsl(210 40% 96.1%)', foreground: 'hsl(222.2 47.4% 11.2%)' },
                            muted: { DEFAULT: 'hsl(210 40% 96.1%)', foreground: 'hsl(215.4 16.3% 46.9%)' },
                            accent: { DEFAULT: 'hsl(210 40% 96.1%)', foreground: 'hsl(222.2 47.4% 11.2%)' },
                            destructive: { DEFAULT: 'hsl(0 84.2% 60.2%)', foreground: 'hsl(210 40% 98%)' },
                            card: { DEFAULT: 'hsl(0 0% 100%)', foreground: 'hsl(222.2 84% 4.9%)' },
                            popover: { DEFAULT: 'hsl(0 0% 100%)', foreground: 'hsl(222.2 84% 4.9%)' },
                            success: 'hsl(142.1 76.2% 36.3%)',
                            warning: 'hsl(38 92% 50%)',
                            info: 'hsl(199.4 89.1% 48.4%)',
                        },
                        fontFamily: {
                            sans: ['Inter', 'Segoe UI', 'system-ui', 'sans-serif'],
                        },
                    },
                },
                darkMode: 'class',
            };
        </script>
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.0/css/buttons.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.dataTables.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
        <script>
            window.toggleTheme = function () {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
            };
            window.toggleSidebar = function () {
                const sb = document.getElementById('app-sidebar');
                if (!sb) return;
                sb.classList.toggle('-translate-x-full');
                localStorage.setItem('sidebar_collapsed', sb.classList.contains('-translate-x-full') ? '1' : '0');
            };
            window.initDataTable = function (selector, options) {
                const defaults = {
                    pageLength: 25,
                    lengthMenu: [10, 25, 50, 100],
                    responsive: true,
                    autoWidth: false,
                    language: {
                        search: '', searchPlaceholder: 'Search...',
                        lengthMenu: '_MENU_ per page',
                        info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                        infoEmpty: 'No entries to show',
                        infoFiltered: '(filtered from _MAX_ total)',
                        paginate: { previous: '←', next: '→' },
                    },
                    dom: '<"flex items-center justify-between mb-4"lfB>rtip',
                    buttons: [
                        { extend: 'csv', text: 'CSV', className: 'inline-flex items-center rounded-md border border-input bg-background px-3 py-1.5 text-xs font-medium hover:bg-accent' },
                        { extend: 'excel', text: 'Excel', className: 'inline-flex items-center rounded-md border border-input bg-background px-3 py-1.5 text-xs font-medium hover:bg-accent' },
                        { extend: 'print', text: 'Print', className: 'inline-flex items-center rounded-md border border-input bg-background px-3 py-1.5 text-xs font-medium hover:bg-accent' },
                    ],
                };
                return $(selector).DataTable({ ...defaults, ...(options || {}) });
            };
            window.confirmDelete = function (msg) { return confirm(msg || 'Are you sure?'); };
            (function () {
                const saved = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (saved === 'dark' || (!saved && prefersDark)) {
                    document.documentElement.classList.add('dark');
                }
            })();
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('table[data-datatable]').forEach(function (table) {
                    const opts = table.dataset.datatableOptions ? JSON.parse(table.dataset.datatableOptions) : {};
                    window.initDataTable(table, opts);
                });
            });
        </script>
    @endif

    @stack('styles')
</head>
<body class="min-h-screen bg-background text-foreground">
<div class="flex min-h-screen">

    {{-- ─── Sidebar ───────────────────────────────────────────────────── --}}
    <aside id="app-sidebar"
           class="fixed inset-y-0 left-0 z-50 w-64 transform border-r bg-card transition-transform duration-300 lg:static lg:translate-x-0 -translate-x-full lg:translate-x-0">
        <div class="flex h-16 items-center gap-2 border-b px-6">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <img src="{{ $schoolLogo ?? asset('backend/dist/img/logo.png') }}" alt="" class="h-8 w-8 rounded-md object-cover" onerror="this.style.display='none'">
                <span class="text-lg font-semibold">{{ $schoolName ?? config('app.name') }}</span>
            </a>
        </div>
        <nav class="flex-1 overflow-y-auto px-3 py-4" style="height: calc(100vh - 8rem);">

            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ isActiveMenu('admin.dashboard') }}">
                <i class="fa fa-tachometer w-4"></i> <span>Dashboard</span>
            </a>

            {{-- Students group --}}
            <div class="mt-4 mb-1 px-3 text-xs font-semibold uppercase tracking-wider text-muted-foreground">Students</div>
            <a href="{{ route('admin.student.index') }}" class="sidebar-link {{ isActiveMenu('admin.student.*') }}">
                <i class="fa fa-user-graduate w-4"></i> <span>Students</span>
            </a>
            <a href="{{ route('admin.category.index') }}" class="sidebar-link {{ isActiveMenu('admin.category.*') }}">
                <i class="fa fa-tags w-4"></i> <span>Categories</span>
            </a>
            <a href="{{ route('admin.class.index') }}" class="sidebar-link {{ isActiveMenu('admin.class.*') }}">
                <i class="fa fa-university w-4"></i> <span>Classes</span>
            </a>
            <a href="{{ route('admin.section.index') }}" class="sidebar-link {{ isActiveMenu('admin.section.*') }}">
                <i class="fa fa-th-large w-4"></i> <span>Sections</span>
            </a>
            <a href="{{ route('admin.session.index') }}" class="sidebar-link {{ isActiveMenu('admin.session.*') }}">
                <i class="fa fa-calendar w-4"></i> <span>Sessions</span>
            </a>
            <a href="{{ route('admin.alumni.index') }}" class="sidebar-link {{ isActiveMenu('admin.alumni.*') }}">
                <i class="fa fa-graduation-cap w-4"></i> <span>Alumni</span>
            </a>

            {{-- Academics --}}
            <div class="mt-4 mb-1 px-3 text-xs font-semibold uppercase tracking-wider text-muted-foreground">Academics</div>
            <a href="{{ route('admin.subject.index') }}" class="sidebar-link {{ isActiveMenu('admin.subject.*') }}">
                <i class="fa fa-book w-4"></i> <span>Subjects</span>
            </a>
            <a href="{{ route('admin.subject-group.index') }}" class="sidebar-link {{ isActiveMenu('admin.subject-group.*') }}">
                <i class="fa fa-folder-open w-4"></i> <span>Subject Groups</span>
            </a>
            <a href="{{ route('admin.timetable.index') }}" class="sidebar-link {{ isActiveMenu('admin.timetable.*') }}">
                <i class="fa fa-clock-o w-4"></i> <span>Timetable</span>
            </a>
            <a href="{{ route('admin.homework.index') }}" class="sidebar-link {{ isActiveMenu('admin.homework.*') }}">
                <i class="fa fa-pencil w-4"></i> <span>Homework</span>
            </a>
            <a href="{{ route('admin.attendence-report.index') }}" class="sidebar-link {{ isActiveMenu('admin.attendence-report.*') }}">
                <i class="fa fa-check-square-o w-4"></i> <span>Attendance</span>
            </a>
            <a href="{{ route('admin.holiday.index') }}" class="sidebar-link {{ isActiveMenu('admin.holiday.*') }}">
                <i class="fa fa-sun-o w-4"></i> <span>Holidays</span>
            </a>

            {{-- Examinations --}}
            <div class="mt-4 mb-1 px-3 text-xs font-semibold uppercase tracking-wider text-muted-foreground">Examinations</div>
            <a href="{{ route('admin.examgroup.index') }}" class="sidebar-link {{ isActiveMenu('admin.examgroup.*') }}">
                <i class="fa fa-folder w-4"></i> <span>Exam Groups</span>
            </a>
            <a href="{{ route('admin.exam.index') }}" class="sidebar-link {{ isActiveMenu('admin.exam.*') }}">
                <i class="fa fa-file-text-o w-4"></i> <span>Exams</span>
            </a>
            <a href="{{ route('admin.examschedule.index') }}" class="sidebar-link {{ isActiveMenu('admin.examschedule.*') }}">
                <i class="fa fa-calendar-times-o w-4"></i> <span>Exam Schedule</span>
            </a>
            <a href="{{ route('admin.examresult.index') }}" class="sidebar-link {{ isActiveMenu('admin.examresult.*') }}">
                <i class="fa fa-trophy w-4"></i> <span>Exam Results</span>
            </a>
            <a href="{{ route('admin.grade.index') }}" class="sidebar-link {{ isActiveMenu('admin.grade.*') }}">
                <i class="fa fa-star w-4"></i> <span>Grades</span>
            </a>
            <a href="{{ route('admin.admitcard.index') }}" class="sidebar-link {{ isActiveMenu('admin.admitcard.*') }}">
                <i class="fa fa-id-card w-4"></i> <span>Admit Cards</span>
            </a>

            {{-- Fees --}}
            <div class="mt-4 mb-1 px-3 text-xs font-semibold uppercase tracking-wider text-muted-foreground">Fees</div>
            <a href="{{ route('admin.student-fee.index') }}" class="sidebar-link {{ isActiveMenu('admin.student-fee.*') }}">
                <i class="fa fa-money w-4"></i> <span>Collect Fees</span>
            </a>
            <a href="{{ route('admin.feecategory.index') }}" class="sidebar-link {{ isActiveMenu('admin.feecategory.*') }}">
                <i class="fa fa-list w-4"></i> <span>Fee Categories</span>
            </a>
            <a href="{{ route('admin.feetype.index') }}" class="sidebar-link {{ isActiveMenu('admin.feetype.*') }}">
                <i class="fa fa-tag w-4"></i> <span>Fee Types</span>
            </a>
            <a href="{{ route('admin.feegroup.index') }}" class="sidebar-link {{ isActiveMenu('admin.feegroup.*') }}">
                <i class="fa fa-group w-4"></i> <span>Fee Groups</span>
            </a>
            <a href="{{ route('admin.feesessiongroup.index') }}" class="sidebar-link {{ isActiveMenu('admin.feesessiongroup.*') }}">
                <i class="fa fa-link w-4"></i> <span>Session Groups</span>
            </a>
            <a href="{{ route('admin.feemaster.index') }}" class="sidebar-link {{ isActiveMenu('admin.feemaster.*') }}">
                <i class="fa fa-credit-card w-4"></i> <span>Fee Master</span>
            </a>
            <a href="{{ route('admin.fees-discount.index') }}" class="sidebar-link {{ isActiveMenu('admin.fees-discount.*') }}">
                <i class="fa fa-percent w-4"></i> <span>Discounts</span>
            </a>

            {{-- Income/Expense --}}
            <div class="mt-4 mb-1 px-3 text-xs font-semibold uppercase tracking-wider text-muted-foreground">Finance</div>
            <a href="{{ route('admin.income.index') }}" class="sidebar-link {{ isActiveMenu('admin.income.*') }}">
                <i class="fa fa-plus-circle w-4"></i> <span>Income</span>
            </a>
            <a href="{{ route('admin.expense.index') }}" class="sidebar-link {{ isActiveMenu('admin.expense.*') }}">
                <i class="fa fa-minus-circle w-4"></i> <span>Expense</span>
            </a>

            {{-- Personnel --}}
            <div class="mt-4 mb-1 px-3 text-xs font-semibold uppercase tracking-wider text-muted-foreground">Personnel</div>
            <a href="{{ route('admin.staff.index') }}" class="sidebar-link {{ isActiveMenu('admin.staff.*') }}">
                <i class="fa fa-users w-4"></i> <span>Staff</span>
            </a>
            <a href="{{ route('admin.role.index') }}" class="sidebar-link {{ isActiveMenu('admin.role.*') }}">
                <i class="fa fa-shield w-4"></i> <span>Roles</span>
            </a>
            <a href="{{ route('admin.department.index') }}" class="sidebar-link {{ isActiveMenu('admin.department.*') }}">
                <i class="fa fa-building w-4"></i> <span>Departments</span>
            </a>
            <a href="{{ route('admin.designation.index') }}" class="sidebar-link {{ isActiveMenu('admin.designation.*') }}">
                <i class="fa fa-id-badge w-4"></i> <span>Designations</span>
            </a>

            {{-- Library --}}
            <div class="mt-4 mb-1 px-3 text-xs font-semibold uppercase tracking-wider text-muted-foreground">Library</div>
            <a href="{{ route('admin.book.index') }}" class="sidebar-link {{ isActiveMenu('admin.book.*') }}">
                <i class="fa fa-book w-4"></i> <span>Books</span>
            </a>
            <a href="{{ route('admin.book-issue.index') }}" class="sidebar-link {{ isActiveMenu('admin.book-issue.*') }}">
                <i class="fa fa-exchange w-4"></i> <span>Book Issues</span>
            </a>

            {{-- Inventory / Transport / Hostel --}}
            <div class="mt-4 mb-1 px-3 text-xs font-semibold uppercase tracking-wider text-muted-foreground">Operations</div>
            <a href="{{ route('admin.inventory-item.index') }}" class="sidebar-link {{ isActiveMenu('admin.inventory-item.*') }}">
                <i class="fa fa-cubes w-4"></i> <span>Inventory</span>
            </a>
            <a href="{{ route('admin.transport-route.index') }}" class="sidebar-link {{ isActiveMenu('admin.transport-route.*') }}">
                <i class="fa fa-bus w-4"></i> <span>Transport</span>
            </a>
            <a href="{{ route('admin.hostel.index') }}" class="sidebar-link {{ isActiveMenu('admin.hostel.*') }}">
                <i class="fa fa-bed w-4"></i> <span>Hostel</span>
            </a>

            {{-- Front Office --}}
            <div class="mt-4 mb-1 px-3 text-xs font-semibold uppercase tracking-wider text-muted-foreground">Front Office</div>
            <a href="{{ route('admin.enquiry.index') }}" class="sidebar-link {{ isActiveMenu('admin.enquiry.*') }}">
                <i class="fa fa-question-circle w-4"></i> <span>Enquiries</span>
            </a>
            <a href="{{ route('admin.complaint.index') }}" class="sidebar-link {{ isActiveMenu('admin.complaint.*') }}">
                <i class="fa fa-exclamation-circle w-4"></i> <span>Complaints</span>
            </a>
            <a href="{{ route('admin.visitors.index') }}" class="sidebar-link {{ isActiveMenu('admin.visitors.*') }}">
                <i class="fa fa-users w-4"></i> <span>Visitors</span>
            </a>

            {{-- Front CMS --}}
            <div class="mt-4 mb-1 px-3 text-xs font-semibold uppercase tracking-wider text-muted-foreground">Front CMS</div>
            <a href="{{ route('admin.frontcms-page.index') }}" class="sidebar-link {{ isActiveMenu('admin.frontcms-page.*') }}">
                <i class="fa fa-file-text w-4"></i> <span>Pages</span>
            </a>
            <a href="{{ route('admin.frontcms-media.index') }}" class="sidebar-link {{ isActiveMenu('admin.frontcms-media.*') }}">
                <i class="fa fa-picture-o w-4"></i> <span>Media</span>
            </a>
            <a href="{{ route('admin.frontcms-menu.index') }}" class="sidebar-link {{ isActiveMenu('admin.frontcms-menu.*') }}">
                <i class="fa fa-bars w-4"></i> <span>Menus</span>
            </a>

            {{-- Communicate --}}
            <div class="mt-4 mb-1 px-3 text-xs font-semibold uppercase tracking-wider text-muted-foreground">Communicate</div>
            <a href="{{ route('admin.send-notification.index') }}" class="sidebar-link {{ isActiveMenu('admin.send-notification.*') }}">
                <i class="fa fa-bell w-4"></i> <span>Notifications</span>
            </a>
            <a href="{{ route('admin.chat.index') }}" class="sidebar-link {{ isActiveMenu('admin.chat.*') }}">
                <i class="fa fa-comments w-4"></i> <span>Chat</span>
            </a>

            {{-- Reports --}}
            <div class="mt-4 mb-1 px-3 text-xs font-semibold uppercase tracking-wider text-muted-foreground">Reports</div>
            <a href="{{ route('admin.reports.student') }}" class="sidebar-link {{ isActiveMenu('admin.reports.*') }}">
                <i class="fa fa-bar-chart w-4"></i> <span>Student Reports</span>
            </a>
            <a href="{{ route('admin.reports.fee') }}" class="sidebar-link {{ isActiveMenu('admin.reports.*') }}">
                <i class="fa fa-line-chart w-4"></i> <span>Fee Reports</span>
            </a>
            <a href="{{ route('admin.reports.balance') }}" class="sidebar-link {{ isActiveMenu('admin.reports.*') }}">
                <i class="fa fa-balance-scale w-4"></i> <span>Balance Sheet</span>
            </a>

            {{-- System --}}
            <div class="mt-4 mb-1 px-3 text-xs font-semibold uppercase tracking-wider text-muted-foreground">System</div>
            <a href="{{ route('admin.schsettings.index') }}" class="sidebar-link {{ isActiveMenu('admin.schsettings.*') }}">
                <i class="fa fa-cogs w-4"></i> <span>Settings</span>
            </a>
            <a href="{{ route('admin.audit.index') }}" class="sidebar-link {{ isActiveMenu('admin.audit.*') }}">
                <i class="fa fa-history w-4"></i> <span>Audit Log</span>
            </a>
            <a href="{{ route('admin.addons.index') }}" class="sidebar-link {{ isActiveMenu('admin.addons.*') }}">
                <i class="fa fa-puzzle-piece w-4"></i> <span>Addons</span>
            </a>
            <a href="{{ route('admin.emailconfig.index') }}" class="sidebar-link {{ isActiveMenu('admin.emailconfig.*') }}">
                <i class="fa fa-envelope w-4"></i> <span>Email Config</span>
            </a>
            <a href="{{ route('admin.smsconfig.index') }}" class="sidebar-link {{ isActiveMenu('admin.smsconfig.*') }}">
                <i class="fa fa-mobile w-4"></i> <span>SMS Config</span>
            </a>
            <a href="{{ route('admin.language.index') }}" class="sidebar-link {{ isActiveMenu('admin.language.*') }}">
                <i class="fa fa-language w-4"></i> <span>Languages</span>
            </a>
            <a href="{{ route('admin.currency.index') }}" class="sidebar-link {{ isActiveMenu('admin.currency.*') }}">
                <i class="fa fa-money-bill w-4"></i> <span>Currencies</span>
            </a>

        </nav>
    </aside>

    {{-- Mobile sidebar backdrop --}}
    <div id="sidebar-backdrop" class="fixed inset-0 z-40 hidden bg-black/40 lg:hidden" onclick="toggleSidebar()"></div>

    {{-- ─── Main content ──────────────────────────────────────────────── --}}
    <div class="flex flex-1 flex-col lg:pl-0">
        {{-- Top header --}}
        <header class="sticky top-0 z-30 flex h-16 items-center gap-4 border-b bg-card px-6">
            <button onclick="toggleSidebar()" class="lg:hidden text-muted-foreground hover:text-foreground">
                <i class="fa fa-bars text-xl"></i>
            </button>

            {{-- Search --}}
            <div class="hidden flex-1 sm:block">
                <div class="relative max-w-md">
                    <i class="fa fa-search absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground text-sm"></i>
                    <input type="text" placeholder="Search..."
                           class="h-9 w-full rounded-md border border-input bg-background pl-9 pr-3 text-sm focus:outline-none focus:ring-2 focus:ring-ring" />
                </div>
            </div>

            <div class="flex-1 sm:hidden"></div>

            {{-- Theme toggle --}}
            <button onclick="toggleTheme()" class="text-muted-foreground hover:text-foreground rounded-md p-2">
                <i class="fa fa-moon-o text-lg dark:hidden"></i>
                <i class="fa fa-sun-o text-lg hidden dark:inline"></i>
            </button>

            {{-- Notifications dropdown --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="relative text-muted-foreground hover:text-foreground rounded-md p-2">
                    <i class="fa fa-bell text-lg"></i>
                    @if (isset($unreadNotifications) && $unreadNotifications > 0)
                        <span class="absolute -top-0 -right-0 flex h-4 w-4 items-center justify-center rounded-full bg-destructive text-[10px] text-destructive-foreground">{{ $unreadNotifications }}</span>
                    @endif
                </button>
                <div x-show="open" @click.outside="open = false" x-transition
                     class="absolute right-0 mt-2 w-80 rounded-md border bg-popover shadow-md z-50" style="display:none">
                    <div class="border-b px-4 py-3">
                        <p class="text-sm font-semibold">Notifications</p>
                    </div>
                    <div class="max-h-96 overflow-y-auto py-1">
                        @forelse ($notifications ?? [] as $notif)
                            <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-accent">
                                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-info/10 text-info">
                                    <i class="fa fa-info"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium">{{ $notif->title ?? $notif->message ?? 'Notification' }}</p>
                                    <p class="text-xs text-muted-foreground">{{ $notif->created_at ?? now()->diffForHumans() }}</p>
                                </div>
                            </a>
                        @empty
                            <div class="px-4 py-6 text-center text-sm text-muted-foreground">No notifications</div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- User menu --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-2 rounded-md p-1 hover:bg-accent">
                    <x-avatar :src="$staffImage ? asset('storage/'.$staffImage) : null" :fallback="substr($staffName ?? '?', 0, 1)" size="sm" />
                    <span class="hidden text-sm font-medium md:inline">{{ $staffName }}</span>
                    <i class="fa fa-chevron-down text-xs text-muted-foreground"></i>
                </button>
                <div x-show="open" @click.outside="open = false" x-transition
                     class="absolute right-0 mt-2 w-56 rounded-md border bg-popover shadow-md z-50" style="display:none">
                    <div class="border-b px-4 py-3">
                        <p class="text-sm font-semibold">{{ $staffName }}</p>
                        <p class="text-xs text-muted-foreground">{{ $staff->email ?? '' }}</p>
                        <p class="mt-1 text-xs"><span class="rounded-full bg-primary/10 px-2 py-0.5 text-primary">{{ $staffRole ?? 'Admin' }}</span></p>
                    </div>
                    <div class="py-1">
                        <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-accent">
                            <i class="fa fa-user text-muted-foreground w-4"></i> Profile
                        </a>
                        <a href="{{ route('admin.schsettings.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-accent">
                            <i class="fa fa-cog text-muted-foreground w-4"></i> Settings
                        </a>
                        <div class="border-t my-1"></div>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-3 px-4 py-2 text-sm text-destructive hover:bg-destructive/10">
                                <i class="fa fa-sign-out w-4"></i> Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- Page content --}}
        <main class="flex-1 p-6">
            {{-- Breadcrumbs --}}
            @hasSection('breadcrumbs')
                <nav class="mb-4 flex items-center gap-2 text-sm text-muted-foreground">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-foreground"><i class="fa fa-home"></i> Home</a>
                    @yield('breadcrumbs')
                </nav>
            @endif

            {{-- Flash messages --}}
            @if (session('success'))
                <div class="mb-4 flex items-center gap-3 rounded-md border border-success/30 bg-success/10 px-4 py-3 text-sm">
                    <i class="fa fa-check-circle text-success"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if (session('warning'))
                <div class="mb-4 flex items-center gap-3 rounded-md border border-warning/30 bg-warning/10 px-4 py-3 text-sm">
                    <i class="fa fa-exclamation-triangle text-warning"></i>
                    <span>{{ session('warning') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 flex items-center gap-3 rounded-md border border-destructive/30 bg-destructive/10 px-4 py-3 text-sm">
                    <i class="fa fa-times-circle text-destructive"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="border-t py-4 px-6 text-center text-xs text-muted-foreground">
            <strong>{{ $schoolName ?? config('app.name') }}</strong> &copy; {{ date('Y') }} · Built on Laravel 12 · Powered by Shadcn UI
        </footer>
    </div>
</div>

@stack('scripts')
</body>
</html>
