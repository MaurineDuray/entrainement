<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType
{
    /**
     * Permet la configuration de base d'un champs
     *
     * @param string $label
     * @param string $placeholder
     * @param array $options
     * @return array
     */
    protected function getConfiguration(string $label, string $placeholder,array $options=[]): array
    {
        return array_merge_recursive([ //fusionne les deux tableaux sans écraser les données
            'label'=> $label,
            'attr'=> [
                'placeholder'=> $placeholder
            ]
            ], $options);
    }
}
