document.addEventListener('DOMContentLoaded', function () {
    // Sidebar toggle for mobile screens.
    var menuToggle = document.getElementById('menuToggle');
    var sidebar = document.getElementById('sidebar');

    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function () {
            sidebar.classList.toggle('open');
        });
    }

    // Password show/hide toggle for login and account creation forms.
    document.querySelectorAll('[data-password-toggle]').forEach(function (button) {
        button.addEventListener('click', function () {
            var input = document.getElementById(button.dataset.passwordToggle);
            var icon = button.querySelector('i');

            if (!input || !icon) {
                return;
            }

            input.type = input.type === 'password' ? 'text' : 'password';
            icon.className = input.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
        });
    });

    // Delete confirmation before removing a request record.
    document.querySelectorAll('.delete-form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!window.confirm('Are you sure you want to delete this request?')) {
                event.preventDefault();
            }
        });
    });

    // Theme preview update when a radio option is selected.
    var themeOptions = document.querySelectorAll('input[name="theme"]');
    if (themeOptions.length) {
        var themeNames = Array.from(themeOptions).map(function (option) {
            return option.value;
        });

        themeOptions.forEach(function (option) {
            option.addEventListener('change', function () {
                themeNames.forEach(function (name) {
                    document.body.classList.remove('theme-' + name);
                });

                document.body.classList.add('theme-' + option.value);
            });
        });
    }
});
