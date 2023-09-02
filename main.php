<?php

namespace TestAPI;

require_once "./vendor/autoload.php";

$testAPI = new API();


// вывод всех пользователей
$users = $testAPI->getUsers();
//print_r($users);


// вывод постов пользователя с id = 3
$userPosts = $testAPI->getUserPosts(3);
//print_r($userPosts);


// вывод всех задач пользователя с id = 2
$userTasks = $testAPI->getUsersTasks(2);
//print_r($userTasks);


// создание поста
$options = [
    'userId' => 1,
    'title' => 'test post creation',
    'body' => 'test test test test test test',
];
$createResponse = $testAPI->createPost($options);
//print_r($createResponse);


// редактирование поста c id = 5
$options = [
    'title' => 'Updated title'
];
$updateResponse = $testAPI->updatePost(5, $options);
print_r($updateResponse);


// удаление поста с id = 1
$deleteResponse = $testAPI->deletePost(1);
//print_r($deleteResponse);

