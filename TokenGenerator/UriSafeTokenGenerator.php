<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Security\Csrf\TokenGenerator;

/**
 * Generates CSRF tokens.
 *
 * @author Bernhard Schussek <bernhard.schussek@symfony.com>
 */
class UriSafeTokenGenerator implements TokenGeneratorInterface
{
    private int $entropy;

    /**
     * Generates URI-safe CSRF tokens.
     *
     * @param int $entropy The amount of entropy collected for each token (in bits)
     */
    public function __construct(int $entropy = 256)
    {
        $this->entropy = $entropy;
    }

    public function generateToken(): string
    {
        // Generate an URI safe base64 encoded string that does not contain "+",
        // "/" or "=" which need to be URL encoded and make URLs unnecessarily
        // longer.
        $bytes = random_bytes($this->entropy / 8);

        return rtrim(strtr(base64_encode($bytes), '+/', '-_'), '=');
    }
}
