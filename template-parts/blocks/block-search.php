<div class="search">
    <form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
        <label>
            <input type="search" class="search-field" placeholder="<?php pll_e( 'Search' ); ?>" value="<?php echo get_search_query(); ?>" name="s">
            <a class="close-search" href="#">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1L13 13M1 13L13 1" stroke="currentColor" stroke-width="2"/>
                </svg>
            </a>
        </label>
    </form>
</div>