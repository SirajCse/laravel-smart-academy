import './bootstrap';
import 'jquery';
import Alpine from 'alpinejs';
import DataTable from 'datatables.net-dt';
import Buttons from 'datatables.net-buttons-dt';
import Responsive from 'datatables.net-responsive-dt';

// Initialize jQuery + DataTables globally
window.$ = window.jQuery = jQuery;
DataTable(window, $);
Buttons(window, $);
Responsive(window, $);

// Initialize Alpine.js for dropdowns/modals
window.Alpine = Alpine;
Alpine.start();

// Theme toggle (persisted in localStorage)
window.toggleTheme = function () {
    const isDark = document.documentElement.classList.toggle('dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
};

(function applySavedTheme() {
    const saved = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    if (saved === 'dark' || (!saved && prefersDark)) {
        document.documentElement.classList.add('dark');
    }
})();

// Sidebar collapse (persisted)
window.toggleSidebar = function () {
    const sidebar = document.getElementById('app-sidebar');
    if (!sidebar) return;
    sidebar.classList.toggle('-translate-x-full');
    localStorage.setItem('sidebar_collapsed', sidebar.classList.contains('-translate-x-full') ? '1' : '0');
};

// Generic DataTable initializer — pages can call `initDataTable('#tableId', options)`
window.initDataTable = function (selector, options) {
    const defaults = {
        pageLength: 25,
        lengthMenu: [10, 25, 50, 100],
        responsive: true,
        autoWidth: false,
        language: {
            search: '',
            searchPlaceholder: 'Search...',
            lengthMenu: '_MENU_ per page',
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            infoEmpty: 'No entries to show',
            infoFiltered: '(filtered from _MAX_ total)',
            paginate: {
                previous: '←',
                next: '→',
            },
        },
        dom: '<"flex items-center justify-between mb-4"lfB>rtip',
        buttons: [
            { extend: 'csv',   text: 'CSV',   className: 'inline-flex items-center rounded-md border border-input bg-background px-3 py-1.5 text-xs font-medium hover:bg-accent' },
            { extend: 'excel', text: 'Excel', className: 'inline-flex items-center rounded-md border border-input bg-background px-3 py-1.5 text-xs font-medium hover:bg-accent' },
            { extend: 'print', text: 'Print', className: 'inline-flex items-center rounded-md border border-input bg-background px-3 py-1.5 text-xs font-medium hover:bg-accent' },
        ],
    };
    return $(selector).DataTable({ ...defaults, ...(options || {}) });
};

// Confirm-delete helper for forms
window.confirmDelete = function (message) {
    return confirm(message || 'Are you sure you want to delete this record? This action cannot be undone.');
};

// Auto-init any [data-datatable] elements on page load
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('table[data-datatable]').forEach(function (table) {
        const opts = table.dataset.datatableOptions ? JSON.parse(table.dataset.datatableOptions) : {};
        window.initDataTable(table, opts);
    });
});
