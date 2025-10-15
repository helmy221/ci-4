<?php

if (! function_exists('showAlert')) {
    function showConfirm($title, $text, $method, $params = [], $confirmText = 'Yes, proceed!', $cancelText = 'Cancel')
    {
        $this->dispatch('show-confirm', [
            'title' => $title,
            'text' => $text,
            'method' => $method,
            'params' => $params,
            'confirmText' => $confirmText,
            'cancelText' => $cancelText,
        ]);
    }
}
