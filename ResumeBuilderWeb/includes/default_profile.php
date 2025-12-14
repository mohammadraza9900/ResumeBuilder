<?php
function getDefaultProfilePicture() {
    return 'data:image/svg+xml;base64,' . base64_encode('<?xml version="1.0" encoding="UTF-8"?>
    <svg width="150px" height="150px" viewBox="0 0 150 150" version="1.1" xmlns="http://www.w3.org/2000/svg">
        <circle cx="75" cy="75" r="75" fill="#E0E0E0"/>
        <circle cx="75" cy="60" r="25" fill="#9E9E9E"/>
        <path d="M 75,95 C 45,95 25,115 25,145 L 125,145 C 125,115 105,95 75,95 Z" fill="#9E9E9E"/>
    </svg>');
}
?> 