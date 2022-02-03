<?php

class Utils
{

    /**
     * Sanitize value
     *
     * @param string $value
     *  The value of the malicious string you want to sanitize
     * @return string
     *  Return the sanitized string
     */
    public function sanitize($value)
    {
        $data = trim($value);
        $data = htmlspecialchars($data, ENT_QUOTES, "UTF-8");
        $data = filter_var($data, FILTER_SANITIZE_STRING);
        $data = strip_tags($data);
        return $data;
    }

    /**
     * Show custom alerts when needed
     *
     * @param string $message
     *  The message you want to show
     * @param string $style
     *  The style of the message using bootstrap colors
     * @param string $icon
     *  The alert icon using font awesome icons
     * @return string
     *  Return a formatted message as an HTML code
     */
    public function alert($message, $style = "primary", $icon = "info-circle")
    {
        if ($icon != null) {
            $icon = sprintf('<span class="fas fa-%s"></span>', $this->sanitize($icon));
        } else {
            $icon = "";
        }

        return sprintf(
            '<div class="alert alert-%s">%s %s</div>',
            $this->sanitize($style),
            $icon,
            $this->sanitize($message)
        );
    }

    /**
     * Show dismissible alerts when needed
     *
     * @param string $message
     *  The message you want to show
     * @param string $style
     *  The style of the message using bootstrap colors
     * @param string $icon
     *  The alert icon using font awesome icons
     * @return string
     *  Return a formatted message as an HTML code
     */
    public function dismissibleAlert($message, $style = "primary", $icon = "info-circle")
    {
        if ($icon != null) {
            $icon = sprintf('<span class="fa fa-%s"></span>', $this->sanitize($icon));
        } else {
            $icon = "";
        }

        return sprintf(
            '<div class="alert alert-%s alert-dismissible fade show">
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>%s %s
             </div>',
            $this->sanitize($style),
            $icon,
            $message
        );
    }

    /**
     * Redirect a user to a page when needed
     *
     * @param string $url
     *  The URL or the page you want to redirect the user to it.
     * @return void
     */
    public function redirect($url)
    {
        header('Location: ' . $url, true, 301);
        exit;
    }

    public function random_str($length = 64)
    {
        $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#%^&*()';

        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;

        for ($i = 0; $i < $length; ++$i) {
            $pieces[] = $keyspace[random_int(0, $max)];
        }

        return implode('', $pieces);
    }
}
