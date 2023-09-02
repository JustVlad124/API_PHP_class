<?php

namespace TestAPI;


class API
{
    private string $apiAddress = "https://jsonplaceholder.typicode.com";

    public function getUsers()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->apiAddress . "/users");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $data = json_decode(curl_exec($ch), true);

        $this->checkErrors($ch);

        curl_close($ch);

        return $data;
    }

    public function getPost(int $postId)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->apiAddress . "/posts/" . $postId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $data = json_decode(curl_exec($ch), true);

        $this->checkErrors($ch);

        curl_close($ch);

        return $data;
    }

    public function getUserPosts(int $userId)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->apiAddress . "/posts?userId=" . $userId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $data = json_decode(curl_exec($ch), true);

        $this->checkErrors($ch);

        curl_close($ch);

        return $data;
    }

    public function getUsersTasks(int $userId)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->apiAddress . "/todos?userId=" . $userId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $data = json_decode(curl_exec($ch), true);

        $this->checkErrors($ch);

        curl_close($ch);

        return $data;
    }

    /**
     * @param array $options $options array must have the following structure: userId[int] - individual user number, title[string] - post title, body[string] - post content
     * @return array
     */
    public function createPost(array $options = []): array
    {
        $options['id'] = uniqid();

        $jsonData = json_encode($options);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->apiAddress . '/posts');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

        $response = json_decode(curl_exec($ch), true);

        $this->checkErrors($ch);

        curl_close($ch);

        // to confirm that request was successful
        $response['curl_info'] = curl_getinfo($ch);

        return $response;
    }

    /**
     * @param array $options $options array must have the following structure: userId[int] - individual user number, title[string] - post title, body[string] - post content
     * @return array
     */
    public function updatePost(int $postId, array $options = []): array
    {
        $postData = $this->getPost($postId);

        foreach ($postData as $key => $value) {
            if (in_array($key, array_keys($options))) {
                $postData[$key] = $options[$key];
            }
        }

        $postData = json_encode($postData);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->apiAddress . '/posts/' . $postId);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = json_decode(curl_exec($ch), true);

        $this->checkErrors($ch);

        curl_close($ch);

        // to confirm that request was successful
        $response['curl_info'] = curl_getinfo($ch);

        return $response;
    }

    public function deletePost(int $postId)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->apiAddress . '/posts/' . $postId);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = json_decode(curl_exec($ch), true);

        $this->checkErrors($ch);

        curl_close($ch);

        // to confirm that request was successful
        $response['curl_info'] = curl_getinfo($ch);

        return $response;
    }

    private function checkErrors($ch)
    {
        $info = curl_getinfo($ch);

        if (curl_errno($ch) || substr($info['http_code'], 0, 1) !== '2')
        {
            throw new \Exception(curl_error($ch));
        }
    }
}

?>