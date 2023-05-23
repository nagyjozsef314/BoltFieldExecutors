# Description
This is an example of a BOLT5 (Symfony 5.4) extension, with **demonstration** purposes. Symfony services definitions are missing, so currently after installation it can't be used as is.

## Scope
The scope of the extension is to provide classes which are modifying field(s) values.

As a use case, we can mutate one field's or a field collection's value(s) before saving a content type. The processor classes used by this example are meant to encrypt the field values using sodium library's features.

## One usage scenario
To initiate the mutations we can use a Symfony standard subscriber like below:

```PHP
    /**
     * @return array[]
     */
    public static function getSubscribedEvents()
    {
        return [
            // This is the awaited BOLT CMS event
            ContentEvent::PRE_SAVE => ['handleContentPreSave', 0]
        ];
    }

```

The `handleContentPreSave` method is calling a sequence executor over a field collection:

```PHP
    public function processCollectionField(iterable $fieldCollection): void
    {
        (new SequenceExecutorOnFieldCollection())
            ->executeSequenceOnCollection(
                $fieldCollection,
                [
                    new AdminCredentialEncryptor($this->stringEncryptor),
                    new AdminCredentialPersister($this->entityManager),
                ]
            );
    }
```
