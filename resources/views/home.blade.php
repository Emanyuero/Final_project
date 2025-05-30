@extends('layout.app')

@section('content')
<div class="text-center">
    <h1 class="display-4 mb-4">😂 Random Joke Generator</h1>
    <button onclick="getJoke()" class="btn btn-primary btn-lg mb-3">Get a Joke</button>

    <div id="joke" class="mt-4 p-4 mx-auto" style="max-width: 600px; font-size: 1.5rem; background-color: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); min-height: 100px;">
        <p class="text-muted">Your joke will appear here...</p>
    </div>
</div>

<!-- Bootstrap Modals -->
<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-3">
      <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
        <span class="visually-hidden">Loading...</span>
      </div>
      <div class="mt-2">Loading, please wait...</div>
    </div>
  </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Success</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="successMessage"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="closeSuccessModal">OK</button>
      </div>
    </div>
  </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Error</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="errorMessage"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="closeErrorModal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
    const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));

    // Function to fetch and display a random joke
    window.getJoke = function() {
        const jokeBox = document.getElementById("joke");
        // Clear joke box while loading
        jokeBox.innerHTML = "";

        // Show loading modal
        loadingModal.show();

        fetch('/api/joke')
            .then(res => res.json())
            .then(data => {
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
                jokeBox.innerHTML = "<p class='text-danger'>⚠️ Failed to load a joke. Try again.</p>";
                document.getElementById('errorMessage').textContent = "Failed to load a joke. Please try again.";
                errorModal.show();
            })
            .finally(() => {
                // Hide loading modal once the joke is loaded or error occurs
                loadingModal.hide();
            });
    }

    // Function to save the joke
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
            document.getElementById('successMessage').textContent = data.message;
            successModal.show();
        })
        .catch(error => {
            if (error.message === 'duplicate') {
                document.getElementById('errorMessage').textContent = "This joke is already saved!";
            } else {
                document.getElementById('errorMessage').textContent = "Failed to save joke. Try again.";
            }
            errorModal.show();
        })
        .finally(() => {
            // Hide loading modal once the joke is saved or error occurs
            loadingModal.hide();
        });
    }

    // Close the success modal and ensure loading modal is hidden
    document.getElementById('closeSuccessModal')?.addEventListener('click', () => {
        loadingModal.hide();
    });

    // Close the error modal and ensure loading modal is hidden
    document.getElementById('closeErrorModal')?.addEventListener('click', () => {
        loadingModal.hide();
    });
});
</script>
@endpush
