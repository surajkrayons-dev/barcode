<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use App\Mail\RegistrationRegisteredMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Services\BadgeGenerator;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = Registration::latest();

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('registration_no', 'like', "%{$search}%")
                    ->orWhere('full_name', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");

            });

        }

        if ($request->filled('status') || $request->status === '0') {
            $query->where('status', $request->status);
        }

        $registrations = $query->paginate(10)->withQueryString();

        return view('registrations.index', compact('registrations'));
    }

    public function getCreate()
    {
        return view('registrations.create');
    }

    public function postCreate(Request $request)
    {
        $validated = $request->validate([
            'email'                     => 'required|email|unique:registrations,email',
            'title'                     => 'required',
            'first_name'                => 'required|string|max:100',
            'last_name'                 => 'nullable|string|max:100',
            'gender'                    => 'nullable|string|max:100',
            'job_title'                 => 'required',
            'job_function'              => 'required',
            'phone'                     => 'required|max:10|unique:registrations,phone',
            'company_name'              => 'required',
            'address'                   => 'required',
            'country'                   => 'required',
            'pincode'                   => 'required',
            'state'                     => 'required',
            'city'                      => 'required',
            'website'                   => 'nullable',
            'industry_segment'          => 'required',
            'business_nature'           => 'required',
            'primary_product_group'     => 'required',
            'additional_product_group'   => 'nullable|array',
            'additional_product_group.*' => 'string|in:gifts,stationery,houseware,toys,other',
            'terms'                     => 'accepted',
            'agree_children_policy'     => 'accepted',
        ]);

        $validated['registration_no'] = 'REG'.date('Y').str_pad((Registration::count()+1),5,'0',STR_PAD_LEFT);

        $validated['full_name'] = trim(
            $validated['first_name'].' '.($validated['last_name'] ?? '')
        );

        $validated['terms'] = $request->boolean('terms');
        $validated['agree_children_policy'] = $request->boolean('agree_children_policy');
        $validated['status'] = true;

        $registration = Registration::create($validated);

        $qrData = implode(PHP_EOL, [
            "Registration No : {$registration->registration_no}",
            "Visitor Name : {$registration->full_name}",
            "Company : {$registration->company_name}",
            "Email : {$registration->email}",
            "Phone : {$registration->phone}",
        ]);

        $result = new Builder(
            writer: new PngWriter(),
            data: $qrData,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Medium,
            size: 500,
            margin: 20,
        );

        $qrImage = $result->build()->getString();

        Storage::disk('public')->put(
            'registration-qrcode/'.$registration->registration_no.'.png',
            $qrImage
        );

        $emailBadgePath = $this->generateBadge($registration);

        $downloadBadgePath = $this->generateDownloadCard($registration);

        try {

            Mail::to($registration->email)
                ->send(new RegistrationRegisteredMail(
                    $registration,
                    $emailBadgePath
                ));

        } catch (\Exception $e) {

            Log::error($e->getMessage());

        }

        return redirect()
            ->route('registration.create')
            ->with([
                'success' => 'Registration created successfully.',
                'badge'   => route('badge.download', $registration->registration_no),
            ]);
    }

    public function getUpdate($id)
    {
        $registration = Registration::findOrFail($id);

        return view('registrations.update',compact('registration'));
    }

    public function postUpdate(Request $request,$id)
    {
        $registration = Registration::findOrFail($id);

        $validated = $request->validate([
            'email'                     => 'required|email|unique:registrations,email,'.$id,
            'title'                     => 'required',
            'first_name'                => 'required',
            'last_name'                 => 'nullable',
            'gender'                    => 'nullable',
            'job_title'                 => 'required',
            'job_function'              => 'required',
            'phone'                     => 'required|max:10|unique:registrations,phone,'.$id,
            'company_name'              => 'required',
            'address'                   => 'required',
            'country'                   => 'required',
            'pincode'                   => 'required',
            'state'                     => 'required',
            'city'                      => 'required',
            'website'                   => 'nullable',
            'industry_segment'          => 'required',
            'business_nature'           => 'required',
            'primary_product_group'     => 'required',
            'additional_product_group'   => 'nullable|array',
            'additional_product_group.*' => 'string|in:gifts,stationery,houseware,toys,other',
            'terms'                     => 'accepted',
            'agree_children_policy'     => 'accepted',
        ]);

        $validated['full_name'] = trim(
            $validated['first_name'].' '.($validated['last_name'] ?? '')
        );

        $validated['terms'] = $request->boolean('terms');
        $validated['agree_children_policy'] = $request->boolean('agree_children_policy');
        $validated['status'] = $request->boolean('status');

        $registration->update($validated);

        return redirect()->route('registrations.index')
            ->with('success','Registration updated successfully.');
    }

    public function getFindBadge()
    {
        return view('registrations.find');
    }

    public function postFindBadge(Request $request)
    {
        $request->validate([
            'search' => 'required|string',
        ]);

        $search = $request->search;

        $registration = Registration::where('registration_no', $search)
            ->orWhere('email', $search)
            ->first();

        if (!$registration) {
            return back()
                ->withInput()
                ->with('error', 'Registration Number Or Email Not Found. Please try again.');
        }

        return redirect()->route('registration.view', $registration->id);
    }

    public function view($id)
    {
        $registration = Registration::findOrFail($id);

        return view('registrations.view',compact('registration'));
    }

    public function delete($id)
    {
        $registration = Registration::findOrFail($id);

        $registration->delete();

        return redirect()->route('registrations.index')
            ->with('success','Registration deleted successfully.');
    }

    private function generateBadge($registration)
    {
        $background = imagecreatefromjpeg(public_path('gift.jpg'));

        $white = imagecolorallocate($background, 255, 255, 255);

        $cardX = 170;
        $cardY = 230;
        $cardWidth = 280;
        $cardHeight = 280;

        $this->roundedRectangle(
            $background,
            $cardX,
            $cardY,
            $cardX + $cardWidth,
            $cardY + $cardHeight,
            20,
            $white
        );

        $qr = imagecreatefrompng(
            storage_path(
                'app/public/registration-qrcode/' .
                $registration->registration_no .
                '.png'
            )
        );

        $qrSize = 120;
        $qrX = $cardX + (($cardWidth - $qrSize) / 2);
        $qrY = $cardY + 100;

        imagecopyresampled(
            $background, $qr, $qrX, $qrY, 0, 0,
            $qrSize, $qrSize, imagesx($qr), imagesy($qr)
        );

        $black = imagecolorallocate($background, 0, 0, 0);
        $gray  = imagecolorallocate($background, 90, 90, 90);
        // $font  = 'C:\Windows\Fonts\arial.ttf';
        $font = public_path('fonts/Roboto-Regular.ttf');

        $name = strtoupper($registration->full_name);
        $nameFont = 16;
        $box = imagettfbbox($nameFont, 0, $font, $name);
        $textWidth = $box[2] - $box[0];
        $x = $cardX + ($cardWidth - $textWidth) / 2;
        imagettftext($background, $nameFont, 0, $x, $cardY + 45, $black, $font, $name);

        $company = strtoupper($registration->company_name);
        $companyFont = 10;
        $box = imagettfbbox($companyFont, 0, $font, $company);
        $textWidth = $box[2] - $box[0];
        $x = $cardX + ($cardWidth - $textWidth) / 2;
        imagettftext($background, $companyFont, 0, $x, $cardY + 68, $gray, $font, $company);

        $badgePath = storage_path('app/public/badges/' . $registration->registration_no . '.png');

        if (!file_exists(dirname($badgePath))) {
            mkdir(dirname($badgePath), 0777, true);
        }

        imagepng($background, $badgePath);
        imagedestroy($background);
        imagedestroy($qr);

        return $badgePath;
    }

    private function generateDownloadCard($registration)
    {
        $cardWidth  = 750;
        $cardHeight = 900;

        $badge = imagecreatetruecolor($cardWidth, $cardHeight);

        $white  = imagecolorallocate($badge, 255, 255, 255);
        $black  = imagecolorallocate($badge, 0, 0, 0);
        $border = imagecolorallocate($badge, 210, 210, 210);

        imagefill($badge, 0, 0, $white);
        imagerectangle($badge, 0, 0, $cardWidth - 1, $cardHeight - 1, $border);

        $fontBold = public_path('fonts/Roboto-Bold.ttf');

        $edgeMargin   = 40;
        $maxTextWidth = $cardWidth - ($edgeMargin * 2);
        $gap          = 90; 

        $name = strtoupper($registration->full_name);
        $nameFont = $this->fitFontSize($name, $fontBold, $maxTextWidth, 90, 20);
        $nameHeight = $nameFont * 1.2;

        $qrSize = 400;

        $company = strtoupper($registration->company_name);
        $companyFont = 34;
        $companyLines = $this->wrapText($company, $fontBold, $companyFont, $maxTextWidth);
        $lineHeight = $companyFont * 1.3;
        $companyBlockHeight = count($companyLines) * $lineHeight;

        $totalHeight = $nameHeight + $gap + $qrSize + $gap + $companyBlockHeight;
        $topMargin = ($cardHeight - $totalHeight) / 2;

        $box = imagettfbbox($nameFont, 0, $fontBold, $name);
        $textWidth = $box[2] - $box[0];
        $x = ($cardWidth - $textWidth) / 2;
        $nameY = $topMargin + $nameFont;
        imagettftext($badge, $nameFont, 0, $x, $nameY, $black, $fontBold, $name);

        $qr = imagecreatefrompng(
            storage_path('app/public/registration-qrcode/' . $registration->registration_no . '.png')
        );
        $qrX = ($cardWidth - $qrSize) / 2;
        $qrY = $nameY + $gap;
        imagecopyresampled($badge, $qr, $qrX, $qrY, 0, 0, $qrSize, $qrSize, imagesx($qr), imagesy($qr));

        $lineY = $qrY + $qrSize + $gap + $companyFont;
        foreach ($companyLines as $line) {
            $box = imagettfbbox($companyFont, 0, $fontBold, $line);
            $textWidth = $box[2] - $box[0];
            $x = ($cardWidth - $textWidth) / 2;
            imagettftext($badge, $companyFont, 0, $x, $lineY, $black, $fontBold, $line);
            $lineY += $lineHeight;
        }

        $downloadPath = storage_path('app/public/badge-cards/' . $registration->registration_no . '.png');

        if (!file_exists(dirname($downloadPath))) {
            mkdir(dirname($downloadPath), 0777, true);
        }

        imagepng($badge, $downloadPath);
        imagedestroy($badge);
        imagedestroy($qr);

        return $downloadPath;
    }

    private function fitFontSize($text, $fontPath, $maxWidth, $startSize = 90, $minSize = 20)
    {
        for ($size = $startSize; $size >= $minSize; $size--) {
            $box = imagettfbbox($size, 0, $fontPath, $text);
            $width = $box[2] - $box[0];
            if ($width <= $maxWidth) {
                return $size;
            }
        }
        return $minSize;
    }

    private function wrapText($text, $fontPath, $fontSize, $maxWidth)
    {
        $words = explode(' ', $text);
        $lines = [];
        $currentLine = '';

        foreach ($words as $word) {
            $testLine = $currentLine === '' ? $word : $currentLine . ' ' . $word;
            $box = imagettfbbox($fontSize, 0, $fontPath, $testLine);
            $width = $box[2] - $box[0];

            if ($width > $maxWidth && $currentLine !== '') {
                $lines[] = $currentLine;
                $currentLine = $word;
            } else {
                $currentLine = $testLine;
            }
        }

        if ($currentLine !== '') {
            $lines[] = $currentLine;
        }

        return $lines;
    }

    private function roundedRectangle($img, $x1, $y1, $x2, $y2, $radius, $color)
    {
        imagefilledrectangle($img, $x1 + $radius, $y1, $x2 - $radius, $y2, $color);
        imagefilledrectangle($img, $x1, $y1 + $radius, $x2, $y2 - $radius, $color);

        imagefilledellipse($img, $x1 + $radius, $y1 + $radius, $radius * 2, $radius * 2, $color);
        imagefilledellipse($img, $x2 - $radius, $y1 + $radius, $radius * 2, $radius * 2, $color);
        imagefilledellipse($img, $x1 + $radius, $y2 - $radius, $radius * 2, $radius * 2, $color);
        imagefilledellipse($img, $x2 - $radius, $y2 - $radius, $radius * 2, $radius * 2, $color);
    }
}