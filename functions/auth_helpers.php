<?php

function is_logged_in(): bool
{
    return isset($_SESSION['loggedIn']) && is_array($_SESSION['loggedIn']);
}

function logged_in_role(): ?string
{
    return is_logged_in() ? ($_SESSION['loggedIn']['rol'] ?? null) : null;
}

function is_admin_role(?string $role): bool
{
    return in_array($role, ['admin', 'superadmin'], true);
}

function require_login_and_redirect(?string $returnTo = null): void
{
    if (is_logged_in()) {
        return;
    }

    $target = "../index.php?s=login";
    if ($returnTo) {
        $target .= "&return=" . urlencode($returnTo);
    }

    header("Location: $target");
    exit;
}

function require_admin_and_redirect(): void
{
    if (is_logged_in() && is_admin_role(logged_in_role())) {
        return;
    }

    $_SESSION['login_error'] = 'Necesitás iniciar sesión como admin para acceder al panel.';
    header("Location: ../index.php?s=login&return=admin");
    exit;
}