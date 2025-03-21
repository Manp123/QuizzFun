<!-- results.php -->
<!-- Author: Jack / Christian -->

<?php
session_start();

// Include database connection file
require_once './functions/db_connection.php';

// Retrieve questions and question bank ID from the session
$questions = $_SESSION['questions'];
$questionBankId = $_SESSION['question_bank_id'];

// Function to calculate the score
function calculateScore($userAnswers, $questions) {
    $score = 0;
    foreach ($questions as $index => $question) {
        if (isset($userAnswers[$index]) && $userAnswers[$index] == $question['correct_option']) {
            $score++;
        }
    }
    return $score;
}

$pdo = getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Calculate the score
    $score = calculateScore($_POST['answer'], $questions);

    // Save the score and question bank ID in the session
    $_SESSION['score'] = $score;
    $_SESSION['question_bank_id'] = $questionBankId;
}

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">
<head>
    <script src="./stylesheet/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.118.2">
    <title>Quiz - Result</title>

    <script src="https://kit.fontawesome.com/0f54c6fb31.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="./stylesheet/css/bootstrap.min.css" rel="stylesheet">
    <link href="./stylesheet/css/stylesheet.results.css" rel="stylesheet">

    <!-- Card Animation JS Code -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cards = document.querySelectorAll('.card');

            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('show');
                }, index * 300);
            });
        });

    </script>
</head>
<body class="d-flex h-100 text-center">


<svg xmlns="http://www.w3.org/2000/svg" class="d-none">
    <symbol id="check2" viewBox="0 0 16 16">
        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
    </symbol>
    <symbol id="circle-half" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
    </symbol>
    <symbol id="moon-stars-fill" viewBox="0 0 16 16">
        <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/>
        <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"/>
    </symbol>
    <symbol id="sun-fill" viewBox="0 0 16 16">
        <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
    </symbol>
</svg>

<div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
    <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center"
            id="bd-theme"
            type="button"
            aria-expanded="false"
            data-bs-toggle="dropdown"
            aria-label="Toggle theme (auto)">
        <svg class="bi my-1 theme-icon-active" width="1em" height="1em"><use href="#circle-half"></use></svg>
        <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
        <li>
            <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#sun-fill"></use></svg>
                Light
                <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
            </button>
        </li>
        <li>
            <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#moon-stars-fill"></use></svg>
                Dark
                <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
            </button>
        </li>
        <li>
            <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
                <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#circle-half"></use></svg>
                Auto
                <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
            </button>
        </li>
    </ul>
</div>

<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <header class="mb-auto">
    </header>

    <div class="content-container">
        <main class="px-3">
            <h1><i class="fa-solid fa-square-poll-vertical"></i> Results</h1>
            <p class="lead">Your score: <?php echo isset($score) ? $score : 'Not calculated'; ?> / 10</p>
            <form action="index.php" method="post">
                <input type="submit" value="Choose Another Quiz" class="btn btn-primary">
            </form>
        </main>
        <br>

        <p class="scroll-down-text">SCROLL DOWN TO SHOW ANSWERS</p>
        <span class="mouse-icon"></span>

    </div>

    <?php if (isset($questions)): ?>
        <?php foreach ($questions as $index => $question): ?>
            <div class="card mb-3">
                <div class="card-header">
                    <?php
                    // Initialize $userSelection variable
                    $userSelection = isset($_POST['answer'][$index]) ? htmlspecialchars($_POST['answer'][$index]) : null;

                    $iconColor = ($userSelection == $question['correct_option']) ? '#7ed321' : '#d0021b';
                    ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="<?php echo $iconColor; ?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <?php if ($userSelection == $question['correct_option']): ?>
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        <?php else: ?>
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        <?php endif; ?>
                    </svg>
                    Question <?php echo $index + 1; ?>
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p><?php echo htmlspecialchars($question['question']); ?></p>
                        <footer class="blockquote-footer">
                            <?php
                            $userSelectionIndex = htmlspecialchars($_POST['answer'][$index]);
                            $userSelection = htmlspecialchars($question['option' . $userSelectionIndex]); ?>

                            <p><?php echo 'Your selection: ' . $userSelection; ?></p>
                            <p><?php echo ' (Correct Answer: ' . htmlspecialchars($question['option' . $question['correct_option']]) . ')'; ?> </p>

                        </footer>
                    </blockquote>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>



    <footer class="mt-auto text-white-50">
        Share result to your friends! But if they want to play? Don't tell them answers yet!
    </footer>

    <script src="./stylesheet/js/bootstrap.bundle.js"></script>
</div>
</body>
</html>
