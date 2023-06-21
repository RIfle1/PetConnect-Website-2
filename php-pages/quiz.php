<?php
session_start();
include '../php-processes/dbConnection.php';
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['home'];

?>
<!doctype html>
<html lang="en">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/quiz-styles.css">
    <title>Quiz</title>
</head>

<body>

<main id="quiz-main-div">
    <div class="quiz-container" id="quiz">
        <div class="quiz-header">
            <h2 id="question">MCQS Text</h2>
            <ul>
                <li>
                    <input class="answer" type="radio" name="answer" id="a">
                    <label for="a" id="optionA">Option A</label>
                </li>

                <li>
                    <input class="answer" type="radio" name="answer" id="b">
                    <label for="b" id="optionB">Option B</label>
                </li>

                <li id="option3">
                    <input class="answer" type="radio" name="answer" id="c">
                    <label for="c" id="optionC">Option C</label>
                </li>

                <li id="option4">
                    <input class="answer" type="radio" name="answer" id="d">
                    <label for="d" id="optionD">Option D</label>
                </li>
            </ul>
            <div id="page">1</div>
        </div>

        <button id="submit">Suivant</button>
    </div>
    <script src="../javaScript/quiz.js"></script>
</main>

<?php include '../php-pages/site-footer.php' ?>

<script type="text/javascript">
    // setMarginTop('sih-main-header', 'id', 'quiz-main-div', 'id', 20)

    setToWindowHeight('quiz-main-div', 'id', 0)
    setMarginTopFooter('quiz-main-div', 'id', 'site-footer-main-div', 'id', 0)
</script>

</body>

</html>