<?php
// Replace with your bot token and channel link
$botToken = "7959080598:AAGtJT3ielYWx5sh0iJ4GASnKpDLhSmdBcs";
$channelLink = "https://t.me/viewerchannelbot";

// Get the incoming update from Telegram
$update = file_get_contents("php://input");
$updateArray = json_decode($update, true);

// Check if the update contains a message and /start command
if (isset($updateArray['message'])) {
    $chatId = $updateArray['message']['chat']['id'];
    $messageText = $updateArray['message']['text'];

    if ($messageText === "/start") {
        $welcomeMessage = "Hello! 👋 Welcome to our bot.\nCheck out our channel: [Join here]($channelLink)";
        sendMessage($chatId, $welcomeMessage);
    }
}

// Function to send a message using Telegram API
function sendMessage($chatId, $message) {
    global $botToken;
    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    
    $postData = [
        'chat_id' => $chatId,
        'text' => $message,
        'parse_mode' => 'Markdown'
    ];
    
    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($postData),
        ],
    ];
    
    $context = stream_context_create($options);
    file_get_contents($url, false, $context);
}
?>