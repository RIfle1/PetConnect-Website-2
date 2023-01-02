<?php
session_start();
include '../php-processes/dbConnection.php';
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['home'];

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/quiz-styles.css">
    <title>Quiz</title>
</head>

<body>

    <main>
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
    <?php include 'site-footer.php' ?>
</body>

</html>