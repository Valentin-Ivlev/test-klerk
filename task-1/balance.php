<?php

function balance(string $left, string $right): string
{
    // Используем функцию str_split, чтобы разбить строки на массивы символов
    $left_array = str_split($left);
    $right_array = str_split($right);

    // Используем функцию array_reduce, чтобы просуммировать веса символов в каждом массиве
    // Передаем анонимную функцию, которая добавляет к сумме символов вес текущего символа
    // Используем тернарный оператор, чтобы проверить тип текущего символа и его вес
    $left_weight = array_reduce($left_array, function ($sum, $char) {
        return $sum + ($char == '!' ? 2 : ($char == '?' ? 3 : 0));
    }, 0);

    $right_weight = array_reduce($right_array, function ($sum, $char) {
        return $sum + ($char == '!' ? 2 : ($char == '?' ? 3 : 0));
    }, 0);

    // Используем оператор spaceship (<=>), который возвращает -1, 0 или 1 в зависимости от того, какое число больше
    return [-1 => 'Right', 0 => 'Balance', 1 => 'Left'][$left_weight <=> $right_weight];
}