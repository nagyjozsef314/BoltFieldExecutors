<?php
declare(strict_types=1);

namespace Nj\BoltFieldExecutors\Utils\Credentials;

use Nj\BoltFieldExecutors\Utils\Encryption\EncryptionHelper;
use Bolt\Entity\Content;
use Bolt\Entity\Field;
use Bolt\Entity\Field\CollectionField;
use SodiumException;

/**
 *
 */
class CredentialHelper
{

    /**
     * @var EncryptionHelper
     */
    private EncryptionHelper $encryptionHelper;

    /**
     * @param EncryptionHelper $encryptionHelper
     */
    public function __construct(EncryptionHelper $encryptionHelper)
    {
        $this->encryptionHelper = $encryptionHelper;
    }

    /**
     * @param Content $content Can be a hardware-node, server, or service
     * @return iterable<Field>
     */
    public function getCredentials(Content $content): iterable
    {
        if ($content->hasField('admin_credentials')) {
            /** @var CollectionField $field */
            $field = $content->getField('admin_credentials');
            return (array)$field->getValue();
        }
        return [];
    }

    /**
     * @param string $secret
     * @return string
     * @throws SodiumException
     */
    public function encryptSecret(string $secret): string
    {
        return $this
            ->encryptionHelper
            ->encryptSecret($secret);
    }

    /**
     * @param string $secret
     * @return string
     * @throws SodiumException
     */
    public function decryptSecret(string $secret): string
    {
        return $this
            ->encryptionHelper
            ->decryptSecret($secret);
    }
}
