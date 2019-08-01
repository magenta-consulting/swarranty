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
            // /workspace/magenta/swarranty/dev/libraries/bundle/MagentaSWarrantyModelBundle/src/SonataMedia/Resizer/
//            file_put_contents('file1.pdf', $content);
            // Reads image from PDF
            $imagick->readImage('pdf.png');
            $imagick->setImageFormat('png');

            $time = date('d-m-Y');
            // Writes an image or image sequence Example- converted-0.jpg, converted-1.jpg
//            $imagick->writeImages($time.'.jpg', true);

            // copy form parent::resize
            if (!isset($settings['width'])) {
                throw new \RuntimeException(sprintf('Width parameter is missing in context "%s" for provider "%s"', $media->getContext(), $media->getProviderName()));
            }

            $imageContent = $imagick->getImagesBlob();
            $image = $this->adapter->load($imageContent);

//            var_dump($settings);            die();
//            if (empty($settings['width'])) {
//                $settings['width'] = $settings['height'];
//            } else {
//                $settings['height'] = $settings['width'];
//            }
            $media->setWidth(300);
            $media->setHeight(514);
            $box = $this->getBox($media, $settings);
//            var_dump($box);            die();
            $content = $image
                ->thumbnail($box, $this->mode)
                ->get('png', ['quality' => $settings['quality']]);
            $metadata = $this->metadata->get($media, $out->getName());
//            var_dump($metadata);            exit();
            $metadata['contentType'] = 'image/png';
            $out->setContent($content, $metadata);
        } else {
            parent::resize($media, $in, $out, $format, $settings);
        }
    }
}
