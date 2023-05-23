<?php
declare(strict_types=1);

namespace Nj\BoltFieldExecutors\Utils\Encryption;

use Bolt\Entity\Content;
use Bolt\Entity\Field;
use Bolt\Entity\Field\CollectionField;
use Exception;
use SodiumException;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *
 */
class EncryptionHelper
{
    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * @var string
     */
    private string $encryptionKey;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->encryptionKey = (string)$this
            ->container
            ->getParameter('encryption_key');
    }

    /**
     * @param string $secret
     * @return string
     * @throws SodiumException
     * @throws Exception
     */
    public function encryptSecret(string $secret): string
    {
        try {
            $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        } catch (Exception $exception) {
            throw new Exception('Secret encrypt exception: ' . $exception->getMessage());
        }

        return base64_encode(
            $nonce .
            sodium_crypto_secretbox($secret, $nonce, $this->encryptionKey)
        );
    }

    /**
     * @param string $secret
     * @return string
     * @throws SodiumException
     */
    public function decryptSecret(string $secret): string
    {
        if (!$secret) {
            return '';
        }

        $decryptedValue = sodium_crypto_secretbox_open(
            mb_substr(
                sodium_base642bin($secret, SODIUM_BASE64_VARIANT_ORIGINAL),
                SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit'
            ),
            mb_substr(
                sodium_base642bin($secret, SODIUM_BASE64_VARIANT_ORIGINAL),
                0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit'
            ),
            $this->encryptionKey
        );

        return $decryptedValue === false ? '' : $decryptedValue;
    }

    /**
     * @param Content $credentialOwner Can be a hardware-node, server, or service
     * @return array<Field>
     */
    public function getCredentials(Content $credentialOwner): array
    {
        if ($credentialOwner->hasField("admin_credentials")) {
            /** @var CollectionField $field */
            $field = $credentialOwner->getField("admin_credentials");
            return (array)$field->getValue();
        }
        return [];
    }
}
