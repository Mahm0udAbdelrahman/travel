<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Dashboard\Event\{StoreEventRequest, UpdateEventRequest};
use App\Services\Dashboard\EventService;

class EventController extends Controller
{
    public function __construct(public EventService $eventService) {}
    public function index(Request $request)
    {
        $events = $this->eventService->index();
        return view('dashboard.pages.events.index', compact('events'));
    }
    public function create()
    {
        $category_events = $this->eventService->getCategoryEvents();
        $cities = $this->eventService->getCities();

        return view('dashboard.pages.events.create', compact('category_events', 'cities'));
    }

    public function store(StoreEventRequest $storeEventRequest)
    {

        $data = $storeEventRequest->validated();
        $this->eventService->store($data);
        Session::flash('message', ['type' => 'success', 'text' => __('Event created successfully')]);
        return redirect()->route('Admin.events.index');
    }

    public function show($id)
    {
        $event = $this->eventService->show($id);
        return view('dashboard.pages.events.show', compact('event'));
    }

    public function edit($id)
    {
         $event = $this->eventService->show($id);
         $category_events = $this->eventService->getCategoryEvents();
         $cities = $this->eventService->getCities();

        return view('dashboard.pages.events.edit', compact('event', 'category_events', 'cities'));
    }

    public function update($id, UpdateEventRequest $updateEventRequest)
    {

        $data = $updateEventRequest->validated();
        $this->eventService->update($id, $data);
        Session::flash('message', ['type' => 'success', 'text' => __('Event updated successfully')]);
        return redirect()->route('Admin.events.index');
    }

    public function destroy(string $id)
    {
        $this->eventService->destroy($id);

        return redirect()->route('Admin.events.index')->with('success', 'Event Successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        $this->eventService->bulkDelete($request->ids);

        return redirect()->back()->with('success', 'Event deleted successfully');
    }
}
