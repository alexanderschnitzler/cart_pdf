<?php

declare(strict_types=1);

namespace Extcode\CartPdf\EventListener\Document\Generate;

/*
 * This file is part of the package extcode/cart-pdf.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Event\Document\GenerateDocumentEvent;
use Extcode\CartPdf\Service\DocumentRenderServiceInterface;
use Extcode\CartPdf\Service\FileWriterServiceInterface;

final readonly class DocumentRenderer
{
    public function __construct(
        private DocumentRenderServiceInterface $documentRenderService,
        private FileWriterServiceInterface $fileWriterService,
    ) {}

    public function __invoke(GenerateDocumentEvent $event): void
    {
        $orderItem = $event->getOrderItem();

        $this->fileWriterService->writeContentToFile(
            $orderItem,
            $event->getType(),
            $this->documentRenderService->renderDocument(
                $orderItem,
                $event->getType()
            )
        );
    }
}
