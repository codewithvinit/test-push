<?php
namespace Modules\Hike\Admin;

use Illuminate\Http\Request;
use Modules\AdminController;
use Modules\Hike\Models\Hike;
use Modules\Hike\Models\HikeCategory;

class BookingController extends AdminController
{
    protected $hikeClass;
    public function __construct()
    {
        $this->setActiveMenu('admin/module/hike');
        parent::__construct();
        $this->hikeClass = Hike::class;
    }

    public function index(Request $request){

        $this->checkPermission('hike_create');

        $q = $this->hikeClass::query();

        if($request->query('s')){
            $q->where('title','like','%'.$request->query('s').'%');
        }

        if ($cat_id = $request->query('cat_id')) {
            $cat = HikeCategory::find($cat_id);
            if(!empty($cat)) {
                $q->join('bravo_hike_category', function ($join) use ($cat) {
                    $join->on('bravo_hike_category.id', '=', 'bravo_hikes.category_id')
                        ->where('bravo_hike_category._lft','>=',$cat->_lft)
                        ->where('bravo_hike_category._rgt','>=',$cat->_lft);
                });
            }
        }

        if(!$this->hasPermission('hike_manage_others')){
            $q->where('create_user',$this->currentUser()->id);
        }

        $q->orderBy('bravo_hikes.id','desc');

        $rows = $q->paginate(10);

        $current_month = strtotime(date('Y-m-01',time()));

        if($request->query('month')){
            $date = date_create_from_format('m-Y',$request->query('month'));
            if(!$date){
                $current_month = time();
            }else{
                $current_month = $date->getTimestamp();
            }
        }

        $prev_url = url('admin/module/hike/booking/').'?'.http_build_query(array_merge($request->query(),[
           'month'=> date('m-Y',$current_month - MONTH_IN_SECONDS)
        ]));
        $next_url = url('admin/module/hike/booking/').'?'.http_build_query(array_merge($request->query(),[
           'month'=> date('m-Y',$current_month + MONTH_IN_SECONDS)
        ]));

        $hike_categories = HikeCategory::where('status', 'publish')->get()->toTree();
        $breadcrumbs = [
            [
                'name' => __('Hikes'),
                'url'  => 'admin/module/hike'
            ],
            [
                'name'  => __('Booking'),
                'class' => 'active'
            ],
        ];
        $page_title = __('Hike Booking History');
        return view('Hike::admin.booking.index',compact('rows','hike_categories','breadcrumbs','current_month','page_title','request','prev_url','next_url'));
    }
    public function test(){
        $d = new \DateTime('2019-07-04 00:00:00');

        $d->modify('+ 4 hours');
        echo $d->format('Y-m-d H:i:s');
    }
}