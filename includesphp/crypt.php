<?php
function key_expansion($key, $length = 16) {
    // Derive a longer key using SHA256 hash (key schedule)
    return substr(hash('sha256', $key, true), 0, $length);
}

function xor_bytes($block, $key) {
    $output = '';
    for ($i = 0; $i < strlen($block); $i++) {
        $output .= chr(ord($block[$i]) ^ ord($key[$i]));
    }
    return $output;
}

function encrypt_block($plaintext, $key) {
    $key_expanded = key_expansion($key);
    $block = str_pad($plaintext, 16, "\0");  // Ensure block is 16 bytes
    return xor_bytes($block, $key_expanded);
}

function decrypt_block($ciphertext, $key) {
    $key_expanded = key_expansion($key);
    return rtrim(xor_bytes($ciphertext, $key_expanded), "\0");
}

function encrypt($message, $key) {
    // Break message into 16-byte blocks and encrypt each one
    $blocks = str_split($message, 16);
    $encrypted_blocks = '';
    foreach ($blocks as $block) {
        $encrypted_blocks .= encrypt_block($block, $key);
    }
    return bin2hex($encrypted_blocks);
}

function decrypt($encrypted_message, $key) {
    // Convert hex to binary
    $encrypted_bytes = hex2bin($encrypted_message);
    $blocks = str_split($encrypted_bytes, 16);
    $decrypted_blocks = '';
    foreach ($blocks as $block) {
        $decrypted_blocks .= decrypt_block($block, $key);
    }
    return $decrypted_blocks;
}
/*
// Example usage
$message = "Hello, Carlos! AES";
$key = "my_secret_key";

// Encrypt
$encrypted_message = encrypt($message, $key);
echo "Encrypted: " . $encrypted_message . "\n";

// Decrypt
$decrypted_message = decrypt($encrypted_message, $key);
echo "Decrypted: " . $decrypted_message . "\n";*/
?>