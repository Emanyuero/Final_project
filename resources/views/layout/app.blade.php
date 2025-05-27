<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>😂 Joke Generator</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@700&display=swap" rel="stylesheet" />

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Comic Neue', cursive;
            background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .container {
            flex: 1;
        }
        h1, h2 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }
        .btn-primary {
            background-color: #ff7b54;
            border-color: #ff7b54;
        }
        .btn-success {
            background-color: #28b487;
            border-color: #28b487;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        footer {
            background: #333;
            color: #fff;
            padding: 15px 0;
            text-align: center;
            font-size: 14px;
            margin-top: auto;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .joke-animated {
            animation: fadeInUp 0.5s ease-out;
        }
        .search-jokes-link {
            display: inline-block;
            margin-bottom: 1rem;
            padding: 0.5rem 1.25rem;
            font-weight: 700;
            font-size: 1.1rem;
            color: #ff7b54;
            border: 2px solid #ff7b54;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .search-jokes-link:hover,
        .search-jokes-link:focus {
            background-color: #ff7b54;
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Search link before the main content -->
        <div class="text-center">
            <a href="{{ route('jokes.search') }}" class="search-jokes-link">🔍 Search Jokes</a>
        </div>

        @yield('content')
    </div>

    <footer>
        Made with 🤪 by <strong>Emman and Ando</strong> | Laravel + JokeAPI
    </footer>

    <!-- Loading Modal -->
    <div class="modal fade" id="loadingModal" tabindex="-1" aria-labelledby="loadingModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">
          <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
          </div>
          <div class="mt-3">
            <h5>Loading...</h5>
          </div>
        </div>
      </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">
          <div class="text-success" style="font-size: 2rem;">✅</div>
          <div class="mt-3" id="successMessage">Operation successful!</div>
          <button type="button" class="btn btn-success mt-3" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">
          <div class="text-danger" style="font-size: 2rem;">❌</div>
          <div class="mt-3" id="errorMessage">An error occurred.</div>
          <button type="button" class="btn btn-danger mt-3" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
