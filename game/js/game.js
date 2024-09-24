// JavaScript to handle session progression
document.querySelectorAll('.complete-session').forEach(button => {
    button.addEventListener('click', function () {
        let session = this.getAttribute('data-session');
        document.getElementById('session-' + session).classList.add('d-none');

        let nextSession = parseInt(session) + 1;
        if (document.getElementById('session-' + nextSession)) {
            document.getElementById('session-' + nextSession).classList.remove('d-none');
        } else {
            document.getElementById('quiz-btn').classList.remove('d-none');
        }
    });
});