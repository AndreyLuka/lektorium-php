<?php

namespace App\Form\Type;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PostSetDataEvent;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Event\PreSetDataEvent;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('save', SubmitType::class)
            ->add('price', TextType::class)
        ;

        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function (PreSetDataEvent $event) {
                /** @var Product $product */
                $product = $event->getData();
                $form = $event->getForm();

                // checks if the Product object is "new"
                // If no data is passed to the form, the data is "null".
                // This should be considered a new "Product"
                if (!$product || null === $product->getId()) {
                    $form->add('name', TextType::class);
                    $product->setPrice(10);
                } else {
                    $form->add('isChangeName', CheckboxType::class, [
                        'mapped' => false,
                        'label' => 'Change name?'
                    ]);
                }
            })
            ->addEventListener(FormEvents::POST_SET_DATA, function (PostSetDataEvent $event) {
                /** @var Product $product */
                $product = $event->getData();
                $form = $event->getForm();
                $productName = $product->getName(); // Read data
            })
            ->addEventListener(FormEvents::PRE_SUBMIT, function (PreSubmitEvent $event) {
                $product = $event->getData(); // Array (data from request)
                $form = $event->getForm();
                /** @var Product $originalProduct */
                $originalProduct = $form->getData();

                if (isset($product['isChangeName']) && $product['isChangeName']) {
                    if (!isset($product['name'])) {
                        $product['name'] = $originalProduct->getName();
                        $event->setData($product);
                    }
                    $form->add('name', TextType::class);
                }
            })
            ->addEventListener(FormEvents::SUBMIT, function (SubmitEvent $event) {
                /** @var Product $product */
                $product = $event->getData();
                $form = $event->getForm();
            })
            ->addEventListener(FormEvents::POST_SUBMIT, function (PostSubmitEvent $event) {
                /** @var Product $product */
                $product = $event->getData();
                $form = $event->getForm();
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'allow_extra_fields' => true,
        ]);
    }
}
