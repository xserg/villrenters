{image_header}
<div id="search-keyword">
<div id="search-form-heading">
		<span>Поиск</span>
		<a href="?op=villa&act=search" class="advanced-search-link" rel="nofollow">Расширенный</a>
		<div class="clear"></div>
	</div>
	<form name="searchForm" id="keywordSearchForm" action="http://rurenter.ru/search/" method="get">
	<div id="search-form" class="search-form">
		<div class="search-input">
			<input value="" autocomplete="off" name="keyword" id="searchKeywords" rel="" class="input-keyword default ac_input" type="text">
			<input id="side-search-button" src="/resources/9734/images/skin/orange-go-button1.png" class="search-submit-button" height="24" width="44" type="image">
		</div>
	</div>
	</form>
</div>


	<div id="container">
          <h1>{Self-catering_holiday_rentals_around_the_World} <span>({ALL_CNT})</span></h1>
<strong>Добро пожаловать в Villarenters.ru – Интернет каталог по аренде лучших вилл, домов и апартаментов для проживания и отдыха</strong>
{SPECIAL}
<div id="node-results">

	<div class="results-header">
		<span class="inner">
			<strong>
				{World_Holiday_Destinations}
				<span class="showall"><a href="regions/world">{Show_All}</a></span>
			</strong>
		</span>
		
	</div>
	<div class="results-body clearfix">
    	<div id="mainPageBuckets">
		<div id="search">{SEARCH_FORM}</div>

	<div class="clear"></div>
<!-- BEGIN REGION -->
<div class="regionheader">
	<h3>
	<a href="{REGION_LINK}" class="headerLink"><span>{Holiday_villas_in}</span> {REGION_NAME}<span> ({REGION_CNT})</span></a>
	</h3>
	<div class="show-all-box"><a href="{REGION_ALL_LINK}" class="showall">{Show_All}</a></div>
</div>
<div class="threeBuckets clearfix">
                	<!-- BEGIN COUNTRIES_COLUMN -->
					<ul><!-- BEGIN COUNTRY_ROW -->
                                <li><a href="{COUNTRY_LINK}">{COUNTRY_NAME} ({COUNTRY_CNT})</a></li>
						<!-- END COUNTRY_ROW -->
                 	</ul>
					<!-- END COUNTRIES_COLUMN -->
</div>
<!-- END REGION -->

    	</div>
		<div id="right-column">
<div class="popular-links">
		<h2>{ANNONCE_TITLE}</h2>
		<ul>{ANNONCE}
		<br><br>
		{news}

		</ul>
</div>
<!-- BEGIN COMMENTS --><br>
				<h2>Последние отзывы</h2><br>
			<a href="/?op=comments&act=new"><b>Добавить отзыв</b></a><br><br>
	<!-- BEGIN COMMENT -->
			<div class="review-box first">
				<div class="review-content">
							<h2 class="title"></h2>
					<div class="author">
						<span class="nick"><b>{AUTHOR}</b></span>
						<span class="location bold">{CITY}</span>
					</div>
					<div class="date">
						<span class="reviewed">{Review_Submitted}: <span>{DATE}</span></span>
						<span class="stay">{Date_of_Stay} <span></span></span>
					</div>
					<div class="review-txt">
					<i>{COMMENT_TEXT}  <br><a href="{COMMENT_LINK}">далее...</a></i><br><br>
					</div>
				</div>
				<div class="clear"></div>
				<a href="?op=comments&act=show">еще отзывы...</a>
			</div>
	<!-- END COMMENT -->
<!-- END COMMENTS -->
<br>
{LATEST}<br><br>
{FBLIKE}
		</div>
		<p style="clear: left;">&nbsp;</p>
	</div>
</div>
	</div>

</div>

{BOTTOM}


