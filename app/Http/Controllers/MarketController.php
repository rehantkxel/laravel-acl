<?php
namespace App\Http\Controllers;
use App\Market;
use Illuminate\Http\Request;
class MarketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:market-list|market-create|market-edit|market-delete', ['only' => ['index','show']]);
        $this->middleware('permission:market-create', ['only' => ['create','store']]);
        $this->middleware('permission:market-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:market-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $markets = Market::latest()->paginate(5);
        return view('markets.index',compact('markets'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('markets.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
        Market::create($request->all());
        return redirect()->route('markets.index')
            ->with('success','Market created successfully.');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function show(Market $market)
    {
        return view('markets.show',compact('market'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function edit(Market $market)
    {
        return view('markets.edit',compact('market'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Market $market)
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
        $market->update($request->all());
        return redirect()->route('markets.index')
            ->with('success','Market updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function destroy(Market $market)
    {
        $market->delete();
        return redirect()->route('markets.index')
            ->with('success','Market deleted successfully');
    }
}
