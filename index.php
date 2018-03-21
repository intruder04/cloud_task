<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Content-type: text/plain");

// 1. Строки

// Задание 1
// Написать функцию для подсчета вхождений слова в строку. Поиск вхождений должен быть регистронезависимым.
// То есть результат функции func(‘Никогда не говори никогда’, ‘никогда’) должен быть равен 2.

function countWordInString($wordsArg, $lookupWordArg) {
    $counter = 0;
    $words = explode(" ", trim($wordsArg));
    foreach ($words as $word) {
        if (mb_strtolower($word) === mb_strtolower(trim($lookupWordArg)) || mb_strtoupper($word) === mb_strtoupper(trim($lookupWordArg))) {
            // echo "$word match $lookupWordArg\n"; 
            $counter++;
        } else {
            // echo "$word doesn't match $lookupWordArg\n"; 
        }
    }
    echo "Количество вхождений слова $lookupWordArg: $counter\n";
    return $counter;
}

countWordInString('Никогда не говори никогда ', ' никогда   ');


echo "\n#####################################\n\n";

// Задание 2
// Написать функцию, которая проверяет, не являются ли две фразы перестановками друг друга. Регистр символов во фразе не учитывается..
// Например:
// func(‘Мама мыла раму’, ‘Мыла мама раму’) = true

function rearrangementCheck($string1, $string2) {

    // clean up
    $string1 = preg_replace('/[\s\t\n\r\s]+/', ' ', $string1);
    $string2 = preg_replace('/[\s\t\n\r\s]+/', ' ', $string2);

    $words1 = explode(" ", $string1);
    $words2 = explode(" ", $string2);

    if (sizeof($words1) != sizeof($words2)) {
        echo "size doesn't match"; 
        return false;
    }

    $words2_lower = array_map('mb_strtolower', $words2);
    $words2_upper = array_map('mb_strtoupper', $words2);

    foreach ($words1 as $word) {
        if (in_array(mb_strtolower($word), $words2_lower) || in_array(mb_strtoupper($word), $words2_upper)) {
            // echo "$word in array\n"; 
        } else {
            // echo "$word doesn't match\n"; 
            return false;
        } 
    }
    return true;
}

echo rearrangementCheck('Мама мыла раму', 'Мыла мама   раму') ? "true\n" : "false\n";

echo "\n#####################################\n\n";

// 2. Работа с датами

// Задание 1.
// Вывести текущую дату в формате “2017/04/20 - 09:25”.

// date_default_timezone_set("Europe/Moscow");
echo "Сегодня: " . date("Y/m/d - h:i") . "\n";

// Задание 2.
// Посчитать количество понедельников и количество пятниц в текущем году.

$firstDate = strtotime('first day of january this year');
$lastDate = strtotime('last day of december this year');
$mon = 0;
$fri = 0;
for ($i = $firstDate; $i <= $lastDate; $i = $i + 24*3600) {
    if (date("D", $i) == "Mon") {
        $mon++;
    } elseif (date("D", $i) == "Fri") {
        $fri++;
    }
}
echo "Количество понедельников и пятниц в текущем году: $mon и $fri\n";


// Задание 3.
// Вычислить дату следующего воскресенья.

echo "Следующее воскресенье: " . date("Y/m/d", strtotime('next sunday')) . "\n";

// или другой способ:

$todayDayNumber = date('N', time());
$sunday = date("Y/m/d", time() + 86400 * (7 - $todayDayNumber));
echo "Следующее воскресенье (способ 2): " . $sunday . "\n";

echo "\n#####################################\n\n";


// Рекурсивная функция для вычисления факториала

function factorial($x) {
    if ($x >= 0) {
        if ($x === 0) {
            return 1;
        } else {
            return $x * factorial($x-1);
        }
    } else {
        return "Отрицательное число!";
    }
}

$factTest = 3;
echo "Факториал $factTest: " . factorial($factTest) . "\n";
