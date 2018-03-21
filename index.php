<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Content-type: text/plain"); //чтобы работал символ \n в браузере

// 1. Строки

// Задание 1
// Написать функцию для подсчета вхождений слова в строку. Поиск вхождений должен быть регистронезависимым.
// То есть результат функции func(‘Никогда не говори никогда’, ‘никогда’) должен быть равен 2.

function countWordInString($wordsArg, $lookupWordArg) {
    $counter = 0;
    $words = explode(" ", trim($wordsArg));
    $lookupWordArg = mb_strtolower(trim($lookupWordArg));
    foreach ($words as $word) {
        // upper и lower для надежности, но для кириллицы достаточно чего-то одного
        if (mb_strtolower($word) === $lookupWordArg || mb_strtoupper($word) === $lookupWordArg) {
            $counter++;
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

    $words1 = explode(" ", trim($string1));
    $words2 = explode(" ", trim($string2));

    if (sizeof($words1) != sizeof($words2)) {
        echo "size doesn't match"; 
        return false;
    }

    $words2_lower = array_map('mb_strtolower', $words2);

    foreach ($words1 as $word) {
        $word = mb_strtolower($word);
        if (in_array($word, $words2_lower)) {
            // echo "$word in array\n"; 
            if (($key = array_search($word, $words2_lower)) !== false) {
                // echo "removed ". $words2_lower[$key] . "\n";
                unset($words2_lower[$key]);
            }
        } else {
            // echo "$word doesn't match\n"; 
            return false;
        } 
    }
    return true;
}

echo rearrangementCheck("Мама    мыла       раму\n", 'Мыла мама   раму') ? "true\n" : "false\n";
echo rearrangementCheck("Мама    мама       раму\n", 'раму мама мама') ? "true\n" : "false\n";

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


// Работа с массивами

// 1. Имеются два массива: $a = ['x', 'm', 'g', 's', 'a'] и $b = [3, 5, 1, 4, 2].
// Требуется написать функцию, которая будет принимать на вход два массива и сортировать первый массив
// в порядке возрастания значений во втором массиве. То есть func($a, $b) должно быть равно  ['g', 'a', 'x', 's', 'm'].
// Предусмотреть проверку входящих данных внутри функции.

function sortArray($stringArray, $indexArray) {
    if (sizeof($stringArray) !== sizeof($indexArray)) {
        echo "Размеры массивов не совпадают!\n";
        return 0;
    } elseif (preg_grep('/\D/', $indexArray)) {
        echo "Не все индексы являются целочисленными!\n";
        return 0;
    }
    
    $result = [];
    foreach ($indexArray as $key => $value) {
        if (array_key_exists($value-1, $stringArray)){
            $result[] = $stringArray[$value-1];
        }
    }
    print_r($result);
}

$a = ['x', 'm', 'g', 's', 'a'];
$b = [3, 5, 1, 4, 2];

sortArray($a, $b);



// 2. Написать функцию, которая будет аналогом функции array_merge().

$array1 = array(7 => "data3", "stringkey" => "stringvalueOLD", 8 => 6, 7);
$array2 = array(1 => "data", "asd", "stringkey" => "stringvalueNEW");

function mergeArrays($arr1, $arr2) {
    $result = array_merge($arr1, $arr2); // для сравнения результатов
    print_r($result); 

    $resultArr = [];
    foreach ($arr1 as $key => $value) {
        if (is_string($key)) { // элементы со строкой в качестве ключа
            if (array_key_exists($key, $arr2)) { // перемещение элементов из второго массива в результат при совпадении ключей
                $resultArr[$key] = $arr2[$key]; 
                unset($arr2[$key]);
            } else { 
                $resultArr[$key] = $value; 
            }
        } else {
            $resultArr[] = $value;
        }
    }

    foreach ($arr2 as $value) { // добавляем остатки второго массива в первый
        $resultArr[] = $value;
    }

    print_r($resultArr);
    return $resultArr;
}

mergeArrays($array1, $array2);


// 3. Написать функцию для подсчета суммы числовых значений в массиве произвольной вложенности,
// не используя функцию array_sum. То есть, например, для массива $a = [ [ 12, 18 ], 40, [ 4, 6, [ 10 ] ] ] 
// результат функции должен быть равен 90.

$a = [ [ 12, 18 ], 40, [ 4, 6, [ 10,[2,4] ] ] ];

function arraySumRec($arr) {
    $res = 0;
    foreach ($arr as $value) {
        if (is_array($value)) {
            $res += arraySumRec($value);
        } 
        else {
            $res += $value;
        }
    }
    return $res;
}

echo "Сумма всех значений вложенных массивов: ".arraySumRec($a)."\n";



// 4. Написать функцию которая на вход может принимать два и более массивов. 
// Функция должна искать значения в этих массивах которые встречаются одновременно 
// в нескольких (хотя бы в двух) массивах из переданных. Найденные значения функция должна вернуть в виде массива.
// Пример:
// Массив 1: [1, 5, 6, 8]
// Массив 2: [2, 3, 4, 5]
// Массив 3: [10, 3, 12, 7]

// На выходе должно получится
// [5, 3]

$arr1 = [3, 5, 1, 4, 2, 111];
$arr2 = [3, 5, 1, 4, 2, 11, 551, 1, 11];
$arr3 = [3, 5, 1, 1133, 111, 11];

function searchEqualsInArrays() {
    $result = [];
    $args = func_get_args();
    $argsAmount = func_num_args();
    echo $argsAmount . " массива в аргументах\n";

    for ($i = 0; $i < $argsAmount-1; $i++) {
        echo "i = $i\n";
        foreach ($args[$i] as $arr) {
            if (in_array($arr, $args[$i+1]) && !in_array($arr, $result)) {
                echo "$arr is on array:\n";
                print_r($args[$i+1]);
                $result[] = $arr;
            }
        }
    }
    print_r($result);
}

searchEqualsInArrays($arr1, $arr2, $arr3);

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

echo "\n#####################################\n\n";