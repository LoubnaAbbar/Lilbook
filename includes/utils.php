<?php
function make_slug(string $s): string
{
$s = mb_strtolower(trim($s), 'UTF-8');
$s = preg_replace('~[^\pL\d]+~u', '-', $s);
$s = preg_replace('~[^-\w]+~u', '', $s);
$s = trim($s, '-');
$s = preg_replace('~-+~', '-', $s);
return $s !== '' ? $s : bin2hex(random_bytes(4));
}