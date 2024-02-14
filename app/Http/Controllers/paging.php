$pdf->setOptions([
            'isPhpEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        $pdf->setPaper('legal', 'landscape');
        $pdf->render();

        $pageCount = $pdf->getDomPDF()->get_canvas()->get_page_count();

        $font = 'helvetica';
        $size = 8;
        $style = '';

        $t = 560;
        for ($i = 1; $i <= $pageCount; $i++) {
            $pdf->getDomPDF()->get_canvas()->page_text(480, $t, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, $size, array(0, 0, 0));

            $t += 560;
        }