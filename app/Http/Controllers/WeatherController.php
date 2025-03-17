<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

use Illuminate\Http\Request;
use Illuminate\Routing\RouteUri;

class WeatherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $url = "https://api.openweathermap.org/data/2.5/forecast?id=1586203&appid=6052faefddc28fcd47bce9c4cea209ec&lang=vi";
        $response = Http::get($url);
        $weatherData = $response->json();
    
        // Filter the data for today's date
        $todayDate = date('Y-m-d'); // Get today's date in the format 'YYYY-MM-DD'
        
        $weather = [];
        
        foreach ($weatherData['list'] as $forecast) {
            if (substr($forecast['dt_txt'], 0, 10) === $todayDate) {
                $weather[] = $forecast;
            }
        }
    
        return Inertia::render('Weather', compact('weather'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        echo '<script>window.open("https://www.youtube.com/", "_blank");</script>';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return redirect()->route('weather.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
