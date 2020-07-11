<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;

// Requests

use Illuminate\Http\Request;
use App\Http\Requests\Event\EventRequest;

// Models

use App\Event;
use App\EventRelationShip;
use App\Jobs\ProcessSendEmailAfterApplied;
// Helper Functions

use Illuminate\Support\Str;

class EventController extends Controller
{

    protected static $model;

    public function __construct()
    {
        self::$model = Event::query();
        $this->middleware('auth:api')->only([ 'store' , 'update', 'destroy' , 'apply']);
        $this->middleware('check.policy')->only(['update' , 'destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {

        $list = self::$model;

        if( $req->order_by ){
            $list->orderBy( $req->order_by );
        }

        $list =  $list->paginate(10 , ["*"] , 'page' , $req->page ? $req->page : 0);

        foreach($list as $one_event){
            $one_event->AppliedUsers;
        }

        return response(['events' => $list] , 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        $event_array = $request->validated();

        if($request->hasFile('feature')){
            $file = $request->file('feature');
            $filename = Str::random(12).'.'.$file->getClientOriginalExtension();
            $file->move(public_path("Images"), $filename);
            $path = '/Images/' . $filename;
            $event_array['feature'] = $path;
        }


        $slug = Str::slug($request->title);
        $count_for_unique = 1;

        while(Event::where( 'slug' , $slug)->first()){
            $slug = $slug.'-'.$count_for_unique;
            $count_for_unique++;
        }
        $user = $request->user();
        $event_array['slug'] = $slug;
        $event_array['creator_id'] = $user->id;
        $event_array['creator_name'] = $user->name;

        if( $event = Event::create($event_array)){
            return response($event , 200);
        };
        return response(['message' => 'Internal Server Error , Please try letter'] , 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if( $event = Event::where('id' , $id)->orWhere('slug' , $id)->first()){
            $event->AppliedUsers;
            return response($event , 200);
        }
        return response(['message' => 'Event dosn\'t exists'], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, $id)
    {
        $event_array = $request->validated();

        if($request->hasFile('feature')){
            $file = $request->file('feature');
            $filename = Str::random(12).'.'.$file->getClientOriginalExtension();
            $file->move(public_path("Images"), $filename);
            $path = '/Images/' . $filename;
            $event_array['feature'] = $path;
        }
        $user = $request->user();
        $event_array['creator_id'] = $user->id;
        $event_array['creator_name'] = $user->name;
        $updated = Event::where('id' , $id)->orWhere('slug' , $id)->update($event_array);
        if(!$updated){
            return response(['message' => 'Internal Server Error , Please try letter'] , 500);
        }
        return response( "Event Successfuly changes" , 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $e = Event::where('id' , $id)->orWhere('slug' , $id)->delete();
        if(!$e){
            return response(['message' => 'Bad Request'] , 400);
        }
        return response( "Event Successfuly deleted" , 200);
    }

    public function apply(Request $req , $id)
    {
        $event = Event::where('id' , $id)->orWhere('slug' , $id)->first('id');
        $user = $req->user();

        if( $event && $user ){
            if( !EventRelationShip::where(['user_id' => $user->id , 'event_id' => $event->id]) ){
                EventRelationShip::create(['user_id' => $user->id , 'event_id' => $event->id]);
                ProcessSendEmailAfterApplied::dispatchAfterResponse($user->email , $user->name);
                return response('You Applied Successfully' , 200);
            }
            return response('You already applied thi event' , 200);
        }

        return response('Bad Requst' , 400);
    }
}
