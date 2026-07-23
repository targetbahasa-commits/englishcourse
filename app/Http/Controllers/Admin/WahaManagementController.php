<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WahaManagementController extends Controller
{
    protected string $url;
    protected string $session;
    protected string $apiKey;

    public function __construct()
    {
        $urlSetting = \App\Models\Setting::where('key', 'waha_url')->first();
        $this->url = rtrim($urlSetting && !empty($urlSetting->value) ? $urlSetting->value : config('services.whatsapp.waha.url', 'http://localhost:3000'), '/');

        $sessionSetting = \App\Models\Setting::where('key', 'waha_session_name')->first();
        $this->session = $sessionSetting && !empty($sessionSetting->value) ? $sessionSetting->value : config('services.whatsapp.waha.session', 'default');

        $apiKeySetting = \App\Models\Setting::where('key', 'waha_api_key')->first();
        $this->apiKey = (string) ($apiKeySetting && !empty($apiKeySetting->value) ? $apiKeySetting->value : config('services.whatsapp.waha.api_key', ''));
    }

    /**
     * Get HTTP headers for WAHA API
     */
    protected function getHeaders(): array
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        if (!empty($this->apiKey)) {
            $headers['X-Api-Key'] = $this->apiKey;
        }

        return $headers;
    }

    /**
     * Render the index view
     */
    public function index()
    {
        // View will use Alpine.js to fetch status dynamically
        return view('admin.waha-management.index', [
            'wahaUrl' => $this->url,
            'sessionName' => $this->session,
            'wahaApiKey' => $this->apiKey
        ]);
    }

    /**
     * Get the current status and QR code (if applicable)
     */
    public function status()
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(5)
                ->get($this->url . '/api/sessions', ['all' => 'true']);

            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'status' => 'ERROR',
                    'message' => 'Failed to reach WAHA API. HTTP Status: ' . $response->status()
                ], 500);
            }

            $sessions = $response->json();
            $currentSession = collect($sessions)->firstWhere('name', $this->session);

            if (!$currentSession) {
                return response()->json([
                    'success' => true,
                    'status' => 'STOPPED',
                    'message' => 'Session does not exist or is stopped.'
                ]);
            }

            $status = $currentSession['status'] ?? 'UNKNOWN';
            
            $data = [
                'success' => true,
                'status'  => $status,
                'message' => 'Session is ' . $status,
            ];

            // If we need to scan QR code, fetch it and pass as base64
            if ($status === 'SCAN_QR_CODE') {
                $qrResponse = Http::withHeaders($this->getHeaders())
                    ->timeout(5)
                    ->get($this->url . '/api/sessions/' . $this->session . '/auth/qr?format=image');

                if ($qrResponse->successful()) {
                    $base64 = base64_encode($qrResponse->body());
                    $data['qr_code'] = 'data:image/png;base64,' . $base64;
                }
            }

            return response()->json($data);

        } catch (\Exception $e) {
            Log::error("WAHA Management Status Error: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'status' => 'OFFLINE',
                'message' => 'Cannot connect to WAHA server. Make sure the container is running.'
            ], 500);
        }
    }

    /**
     * Start the WAHA session
     */
    public function start()
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(10)
                ->post($this->url . '/api/sessions/start', [
                    'name' => $this->session
                ]);

            if ($response->successful()) {
                return redirect()->back()->with('success', 'WhatsApp session starting... Please wait for the status to update.');
            }

            return redirect()->back()->with('error', 'Failed to start session. API responded with status ' . $response->status());

        } catch (\Exception $e) {
            Log::error("WAHA Management Start Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Cannot connect to WAHA server.');
        }
    }

    /**
     * Stop the WAHA session
     */
    public function stop()
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(10)
                ->post($this->url . '/api/sessions/stop', [
                    'name' => $this->session
                ]);

            if ($response->successful()) {
                return redirect()->back()->with('success', 'WhatsApp session stopped.');
            }

            return redirect()->back()->with('error', 'Failed to stop session. API responded with status ' . $response->status());

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cannot connect to WAHA server.');
        }
    }

    /**
     * Logout the WAHA session
     */
    public function logout()
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(10)
                ->post($this->url . '/api/sessions/logout', [
                    'name' => $this->session
                ]);

            if ($response->successful()) {
                return redirect()->back()->with('success', 'WhatsApp session logged out. You will need to scan the QR code again.');
            }

            return redirect()->back()->with('error', 'Failed to logout session. API responded with status ' . $response->status());

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cannot connect to WAHA server.');
        }
    }

    /**
     * Update the WAHA session name
     */
    public function updateSessionName(Request $request)
    {
        $request->validate([
            'session_name' => 'required|string|max:255'
        ]);

        $setting = \App\Models\Setting::firstOrNew(['key' => 'waha_session_name']);
        $setting->value = $request->session_name;
        $setting->type = 'string';
        $setting->save();

        return redirect()->back()->with('success', 'WhatsApp session name updated successfully. You can now start the session.');
    }

    /**
     * Update the WAHA API Configuration
     */
    public function updateApiConfig(Request $request)
    {
        $request->validate([
            'waha_url' => 'required|url',
            'waha_api_key' => 'nullable|string'
        ]);

        $urlSetting = \App\Models\Setting::firstOrNew(['key' => 'waha_url']);
        $urlSetting->value = $request->waha_url;
        $urlSetting->type = 'string';
        $urlSetting->save();

        $apiKeySetting = \App\Models\Setting::firstOrNew(['key' => 'waha_api_key']);
        $apiKeySetting->value = $request->waha_api_key ?? '';
        $apiKeySetting->type = 'string';
        $apiKeySetting->save();

        return redirect()->back()->with('success', 'WAHA API Configuration updated successfully.');
    }
}
