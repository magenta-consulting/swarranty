<?php

namespace Magenta\Bundle\SWarrantyModelBundle\SonataMedia\Resizer;

use Gaufrette\File;
use Sonata\MediaBundle\Model\MediaInterface;

class SimpleResizer extends \Sonata\MediaBundle\Resizer\SimpleResizer
{
    public function resize(MediaInterface $media, File $in, File $out, $format, array $settings)
    {
        $content = $in->getContent();
        $contentType = $media->getContentType();
        if ('application/pdf' === $contentType) {
            // create Imagick object
            $imagick = new \Imagick();
            // Reads image from PDF
            $imagick->readImageBlob($content);
            $imagick->setImageFormat("jpg");

            $time = date('d-m-Y');
            // Writes an image or image sequence Example- converted-0.jpg, converted-1.jpg
//            $imagick->writeImages($time.'.jpg', true);


            // copy form parent::resize
            if (!isset($settings['width'])) {
                throw new \RuntimeException(sprintf('Width parameter is missing in context "%s" for provider "%s"', $media->getContext(), $media->getProviderName()));
            }

            $imageContent = $imagick->getImagesBlob();
            $image = $this->adapter->load($imageContent);

            $content = $image
                ->thumbnail($this->getBox($media, $settings), $this->mode)
                ->get($format, ['quality' => $settings['quality']]);

            $out->setContent($content, $this->metadata->get($media, $out->getName()));
        } else {
            parent::resize($media, $in, $out, $format, $settings);
        }
    }
}
