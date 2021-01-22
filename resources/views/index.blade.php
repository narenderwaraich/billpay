@extends('layouts.app')
@section('content')  
<!-- top header -->
<div class="panel-header panel-header-lg">
   <div id="topChart"></div>           
</div>
<!-- end header    -->

<!-- content section -->
<div class="content">
  <div class="row">
    <div class="col-lg-6">
      <div class="card card-chart">
        <div class="card-header">
          <h5 class="card-category">Global Sales</h5>
          <h4 class="card-title">Shipped Products</h4>
          <div class="dropdown">
            <button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown" disabled="">
              <i class="now-ui-icons fa fa-gear"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <a class="dropdown-item" href="#">Something else here</a>
              <a class="dropdown-item text-danger" href="#">Remove Data</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="chart-area" style="height: 320px;">
            <div id="lineChart"></div>
          </div>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="now-ui-icons arrows-1_refresh-69"></i> Just Updated
          </div>
        </div>
      </div>
    </div>
    <!-- end col -->
    <div class="col-lg-6">
      <div class="card card-chart">
        <div class="card-header">
          <h5 class="card-category">Invoice</h5>
          <h4 class="card-title">Invoice Status</h4>
          <div class="dropdown">
            <button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown" disabled="">
              <i class="now-ui-icons fa fa-gear"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <a class="dropdown-item" href="#">Something else here</a>
              <a class="dropdown-item text-danger" href="#">Remove Data</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="chart-area" style="height: 320px;">
            <div id="piChart"></div>
          </div>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="now-ui-icons arrows-1_refresh-69"></i> Just Updated
          </div>
        </div>
      </div>
    </div>
    <!-- end col -->
  </div>

  <!-- Second Row -->
    <div class="row">
    <div class="col-lg-4">
      <div class="card card-chart">
        <div class="card-header">
          <h5 class="card-category">Sale</h5>
          <h4 class="card-title">Today Sale</h4>
          <div class="dropdown">
            <button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown" disabled="">
              <i class="now-ui-icons fa fa-gear"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <a class="dropdown-item" href="#">Something else here</a>
              <a class="dropdown-item text-danger" href="#">Remove Data</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="chart-area sale-area">
            <div><span class="toady-sale-txt-title">Today</span> <span class="toady-sale-txt-title-amount"><i class="fa fa-inr"></i> @if(isset($todaySale)) {{$todaySale}} @else 0 @endif</span></div>
            <div><span class="last-month-sale-txt-title">Last Month</span> <span class="last-month-sale-txt-title-amount"><i class="fa fa-inr"></i> @if(isset($lastMonthSale)) {{$lastMonthSale}} @else 0 @endif </span></div>
            <div><span class="last-year-sale-txt-title">Last Year</span> <span class="last-year-sale-txt-title-amount"><i class="fa fa-inr"></i>  @if(isset($lastYearSale)) {{$lastYearSale}} @else 0 @endif </span></div>
            <div><span class="total-sale-txt-title">Total</span> <span class="total-sale-txt-title-amount"><i class="fa fa-inr"></i>  @if(isset($totalSale)) {{$totalSale}} @else 0 @endif </span></div>
          </div>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="fa fa-clock-o"></i> {{ date('d-m-Y H:i:s') }}
          </div>
        </div>
      </div>
    </div>
    <!-- end col -->
    <div class="col-lg-4">
      <div class="card card-chart">
        <div class="card-header">
          <h5 class="card-category">Client</h5>
          <h4 class="card-title">Today Client</h4>
          <div class="dropdown">
            <button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown" disabled="">
              <i class="now-ui-icons fa fa-gear"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <a class="dropdown-item" href="#">Something else here</a>
              <a class="dropdown-item text-danger" href="#">Remove Data</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="chart-area sale-area">
            <div><span class="toady-sale-txt-title">Today</span> <span class="toady-sale-txt-title-amount"><i class="fa fa-user"></i> @if(isset($todayClient)) {{$todayClient}} @else 0 @endif</span></div>
            <div><span class="last-month-sale-txt-title">Last Month</span> <span class="last-month-sale-txt-title-amount"><i class="fa fa-user"></i> @if(isset($lastMonthClient)) {{$lastMonthClient}} @else 0 @endif </span></div>
            <div><span class="last-year-sale-txt-title">Last Year</span> <span class="last-year-sale-txt-title-amount"><i class="fa fa-user"></i>  @if(isset($lastYearClient)) {{$lastYearClient}} @else 0 @endif </span></div>
            <div><span class="total-sale-txt-title">Total</span> <span class="total-sale-txt-title-amount"><i class="fa fa-user"></i>  @if(isset($totalClient)) {{$totalClient}} @else 0 @endif </span></div>
          </div>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="fa fa-clock-o"></i> {{ date('d-m-Y H:i:s') }}
          </div>
        </div>
      </div>
    </div>
    <!-- end col -->
    <div class="col-lg-4">
      <div class="card card-chart">
        <div class="card-header">
          <h5 class="card-category">Invoice</h5>
          <h4 class="card-title">Today Invoice</h4>
          <div class="dropdown">
            <button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown" disabled="">
              <i class="now-ui-icons fa fa-gear"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <a class="dropdown-item" href="#">Something else here</a>
              <a class="dropdown-item text-danger" href="#">Remove Data</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="chart-area sale-area">
            <div><span class="toady-sale-txt-title">Today</span> <span class="toady-sale-txt-title-amount"><i class="fa fa-file"></i> @if(isset($todayInvoice)) {{$todayInvoice}} @else 0 @endif</span></div>
            <div><span class="last-month-sale-txt-title">Last Month</span> <span class="last-month-sale-txt-title-amount"><i class="fa fa-file"></i> @if(isset($lastMonthInvoice)) {{$lastMonthInvoice}} @else 0 @endif </span></div>
            <div><span class="last-year-sale-txt-title">Last Year</span> <span class="last-year-sale-txt-title-amount"><i class="fa fa-file"></i>  @if(isset($lastYearInvoice)) {{$lastYearInvoice}} @else 0 @endif </span></div>
            <div><span class="total-sale-txt-title">Total</span> <span class="total-sale-txt-title-amount"><i class="fa fa-file"></i>  @if(isset($totalInvoice)) {{$totalInvoice}} @else 0 @endif </span></div>
          </div>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="fa fa-clock-o"></i> {{ date('d-m-Y H:i:s') }}
          </div>
        </div>
      </div>
    </div>
    <!-- end col -->
  </div>
  <!-- end Second row -->
</div>
<!-- end content section -->
<style>
  body {
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
}

#topChart {
  width: 100%;
  height: 340px;
}
#lineChart,
#piChart{
  width: 100%;
  height: 350px;
}
</style>
<script src="/public/amcharts4/core.js"></script>
<script src="/public/amcharts4/charts.js"></script>
<script src="/public/amcharts4/themes/animated.js"></script>
<script>
var data = [@if(isset($paids))@foreach ($paids as $paid)
  {
  "date": "{{$paid->day}}",
  "value": "{{$paid->amount}}"
  }, 
@endforeach @endif];

var firstYear;
var firstMonth;
var lastYear;
var lastMonth;
var currentYear;
var currentMonth;
function getMonthData() {
  var monthData = [];
  for(var i = 0; i < data.length; i++) {
    var date = chart.dateFormatter.parse(data[i].date);
    var y = date.getFullYear();
    var m = date.getMonth();
    lastYear = y;
    lastMonth = m;
    if (!currentYear) {
      currentYear = y;
      currentMonth = m;
      firstYear = y;
      firstMonth = m;
    }
    if (currentYear == y && currentMonth == m) {
      monthData.push(data[i]);
    }
  }
  title.text = chart.dateFormatter.format(new Date(currentYear, currentMonth, 1), "MMMM yyyy");
  isFirstPage();
  isLastPage();
  return monthData;
}

function prevPage() {
  if (!isFirstPage()) {
    currentMonth--;
    if (currentMonth < 0) {
      currentYear--;
      currentMonth = 11;
    }
    chart.data = getMonthData();
  }
}

function nextPage() {
  if (!isLastPage()) {
    currentMonth++;
    if (currentMonth > 11) {
      currentYear++;
      currentMonth = 0;
    }
    chart.data = getMonthData();
  }
}

function isFirstPage() {
  if ((currentYear > firstYear) || (currentMonth > firstMonth)) {
    prev.disabled = false;
    return false;
  }
  else {
    prev.disabled = true;
    return true;
  }
}

function isLastPage() {
  if ((currentYear < lastYear) || (currentMonth < lastMonth)) {
    next.disabled = false;
    return false;
  }
  else {
    next.disabled = true;
    return true;
  }
}

// Themes
am4core.useTheme(am4themes_animated);

// Create chart instance
var chart = am4core.create("topChart", am4charts.XYChart);

// Set input format for the dates
chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

// Title
var title = chart.titles.create();
title.fontSize = 30;
title.marginBottom = 10;
title.fill = am4core.color("#fff");
//title.stroke = am4core.color("red");

// Create axes
var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());


chart.fontSize = 12;
chart.stroke = am4core.color("#fff");

// Create series
var series = chart.series.push(new am4charts.LineSeries());
series.dataFields.valueY = "value";
series.dataFields.dateX = "date";
series.tooltipText = "{value}"
series.strokeWidth = 2;
series.minBulletDistance = 15;
series.fill = "#e91e63";
series.stroke = "#e91e63";

// Drop-shaped tooltips
series.tooltip.pointerOrientation = "vertical";

// Make bullets grow on hover
var bullet = series.bullets.push(new am4charts.CircleBullet());
bullet.circle.strokeWidth = 2;
bullet.circle.radius = 4;
bullet.circle.fill = am4core.color("#fff");

var bullethover = bullet.states.create("hover");
bullethover.properties.scale = 1.3;

// Make a panning cursor
chart.cursor = new am4charts.XYCursor();
chart.cursor.behavior = "panXY";
chart.cursor.xAxis = dateAxis;
chart.cursor.snapToSeries = series;

// Add pagination buttons
var arrow = "M26,14H10l5.17-6.79A2,2,0,0,0,12,4.79l-7.62,10a2,2,0,0,0,0,2.42l7.62,10a2,2,0,0,0,3.18-2.42L10,18H26a2,2,0,0,0,0-4Z";
var prev = chart.plotContainer.createChild(am4core.Button);
prev.dy = -60;
prev.icon = new am4core.Sprite();
prev.icon.fill = am4core.color("#e91e63");
prev.icon.path = arrow;
prev.events.on("hit", prevPage);

var next = chart.plotContainer.createChild(am4core.Button);
next.dy = -60;
next.align = "right";
next.icon = new am4core.Sprite();
next.icon.fill = am4core.color("#e91e63");
next.icon.rotation = 180;
next.icon.path = arrow;
next.events.on("hit", nextPage);

// Set data
chart.data = getMonthData();




///line chart

// Create chart instance
var lineChart = am4core.create("lineChart", am4charts.XYChart);

// Add data
lineChart.data = [{
  "date": "2018/01/01",
  "value": 450,
  "value2": 362,
  "value3": 699
}];

// Create axes
var dateAxis = lineChart.xAxes.push(new am4charts.DateAxis());
dateAxis.renderer.grid.template.location = 0;
dateAxis.renderer.minGridDistance = 30;

var valueAxis = lineChart.yAxes.push(new am4charts.ValueAxis());

valueAxis.events.on("ready", function(ev) {
  ev.target.min = ev.target.min;
  ev.target.max = ev.target.max;
})

// Create series
function createSeries(field, name) {
  var series = lineChart.series.push(new am4charts.ColumnSeries());
  series.dataFields.valueY = field;
  series.dataFields.dateX = "date";
  series.name = name;
  series.tooltipText = "{dateX}: [b]{valueY}[/]";
  series.strokeWidth = 2;
  
  return series;
}

createSeries("value", "Clients");
createSeries("value2", "Invoices");
createSeries("value3", "Sale");

lineChart.legend = new am4charts.Legend();
lineChart.cursor = new am4charts.XYCursor();
lineChart.scrollbarX = new am4core.Scrollbar();




///pi charts
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("piChart", am4charts.PieChart);

// Add data
chart.data = [ @if(isset($finalPiData)) {
  "type": "{{$finalPiData[0]['type']}}",
  "amount": "{{$finalPiData[0]['amount']}}"
}, {
  "type": "{{$finalPiData[1]['type']}}",
  "amount": "{{$finalPiData[1]['amount']}}"
}, {
  "type": "{{$finalPiData[2]['type']}}",
  "amount": "{{$finalPiData[2]['amount']}}"
},{
  "type": "{{$finalPiData[3]['type']}}",
  "amount": "{{$finalPiData[3]['amount']}}"
},{
  "type": "{{$finalPiData[4]['type']}}",
  "amount": "{{$finalPiData[4]['amount']}}"
} @endif];


chart.legend = new am4charts.Legend();
chart.legend.position = "bottom";
chart.innerRadius = am4core.percent(30);
// Add and configure Series
var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "amount";
pieSeries.dataFields.category = "type";
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeWidth = 2;
pieSeries.slices.template.strokeOpacity = 1;


// Put a thick white border around each Slice
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeWidth = 2;
pieSeries.slices.template.strokeOpacity = 1;
pieSeries.slices.template

  // change the cursor on hover to make it apparent the object can be interacted with
  .cursorOverStyle = [
    {
      "property": "cursor",
      "value": "pointer"
    }
  ];

pieSeries.alignLabels = false;
pieSeries.labels.template.bent = true;
pieSeries.labels.template.radius = 3;
pieSeries.labels.template.padding(0,0,0,0);
pieSeries.labels.template.disabled = true;

pieSeries.ticks.template.disabled = true;
pieSeries.colors.list = [
  am4core.color("#04BF37"), ///paid 
  am4core.color("#808080"), /// deposit
  am4core.color("#f37914"), /// overdue
  am4core.color("#E565F3"), /// sent
  am4core.color("#FA3160"),/// Cancel
  // am4core.color("#F9F871"),
];

// This creates initial animation
pieSeries.hiddenState.properties.opacity = 1;
pieSeries.hiddenState.properties.endAngle = -90;
pieSeries.hiddenState.properties.startAngle = -90;

}); // end am4core.ready()

</script>
@endsection