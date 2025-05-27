// Initialize Bootstrap modals (make sure this runs after DOM is loaded)
const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
const successModal = new bootstrap.Modal(document.getElementById('successModal'));
const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));

function getJoke() {
    const jokeBox = document.getElementById("joke");

    // Show loading modal instead of inline loading text
    loadingModal.show();

    fetch('/api/joke')
        .then(res => res.json())
        .then(data => {
            loadingModal.hide();

            let output = '';

            if (data.type === 'single') {
                output += `<p>${data.joke}</p>`;
            } else {
                output += `<p><strong>${data.setup}</strong></p><p>${data.delivery}</p>`;
            }

            output += `
                <button id="saveJokeBtn" class="btn btn-success mt-3">Save Joke</button>
            `;

            jokeBox.innerHTML = `<div class="joke-animated">${output}</div>`;

            document.getElementById('saveJokeBtn').addEventListener('click', () => {
                saveJoke(data);
            });
        })
        .catch(() => {
            loadingModal.hide();

            jokeBox.innerHTML = "<p class='text-danger'>⚠️ Failed to load a joke. Try again.</p>";

            // Optionally, show error modal
            document.getElementById('errorMessage').textContent = "Failed to load a joke. Please try again.";
            errorModal.show();
        });
}

window.saveJoke = function(jokeData) {
    loadingModal.show();

    fetch('/api/save', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            type: jokeData.type,
            joke: jokeData.joke || null,
            setup: jokeData.setup || null,
            delivery: jokeData.delivery || null,
        })
    })
    .then(res => {
        if (res.status === 409) throw new Error('duplicate');
        if (!res.ok) throw new Error('Save failed');
        return res.json();
    })
    .then(data => {
        loadingModal.hide();  // Hide BEFORE showing success modal
        document.getElementById('successMessage').textContent = data.message;
        successModal.show();
    })
    .catch(error => {
        loadingModal.hide();  // Hide BEFORE showing error modal
        if (error.message === 'duplicate') {
            document.getElementById('errorMessage').textContent = "This joke is already saved!";
        } else {
            document.getElementById('errorMessage').textContent = "Failed to save joke. Try again.";
        }
        errorModal.show();
    });
}

