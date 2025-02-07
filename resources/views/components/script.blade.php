<!-- filepath: /d:/projekti/magacin/resources/views/components/script.blade.php -->
<script>
    function showSidebar() {
        let sidebar = document.querySelector('#sidebar');
        let content = document.querySelector('#content');

        content.style.transition = '0.5s';
        sidebar.style.transition = '0.5s';
        if (sidebar.offsetWidth === 0) {
            sidebar.style.visibility = 'visible';
            sidebar.style.width = '150px';
            sidebar.style.padding = '10px';
            if (window.innerWidth < 600) {
                content.style.opacity = '0.25';
            }
            updateSession('sidebar', 'visible');
        } else {
            sidebar.style.width = '0';
            sidebar.style.padding = '0';
            sidebar.style.overflow = 'hidden';
            content.style.opacity = '1';
            updateSession('sidebar', 'hidden');
        }
    }

    function updateSession(key, value) {
        fetch('{{ route('session.update') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ key: key, value: value })
        })
        .then(response => response.json())
        .then(data => console.log(data))
        .catch(error => console.error('Error:', error));
    }

    function getSession(key) {
        fetch('{{ route('session.get') }}?key=' + key, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            let sidebar = document.querySelector('#sidebar');
            let content = document.querySelector('#content');
            if (data.value === 'visible') {
                sidebar.style.visibility = 'visible';
                sidebar.style.width = '150px';
                sidebar.style.padding = '10px';
                if (window.innerWidth < 600) {
                    content.style.opacity = '0.25';
                }
            } else {
                sidebar.style.width = '0';
                sidebar.style.padding = '0';
                sidebar.style.overflow = 'hidden';
                content.style.opacity = '1';
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Dobijanje sesijske vrednosti prilikom učitavanja stranice
    document.addEventListener('DOMContentLoaded', function() {
        getSession('sidebar');
    });
</script>
