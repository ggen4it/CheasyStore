<?php
// Add custom Theme Functions here

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Bump the version number to ensure the category setup function re-runs
if ( ! defined( 'ELGRECO_CHILD_CATEGORIES_VERSION' ) ) {
    define( 'ELGRECO_CHILD_CATEGORIES_VERSION', '6.0.0' );
}

if ( ! function_exists( 'elgreco_child_get_category_definitions' ) ) {
    /**
     * Return the hierarchical list of all WooCommerce categories.
     * The 'parent' key links a category to its parent by its slug.
     *
     * @return array<string, array<string, mixed>>
     */
    function elgreco_child_get_category_definitions() {
        return [
            // Women's Clothing Hierarchy
            'womens-clothing' => ['name' => "Women's Clothing", 'parent' => null],
            'womens-tops' => ['name' => "Women's Tops", 'parent' => 'womens-clothing'],
            'womens-t-shirts-tees' => ['name' => "Women's T-Shirts & Tees", 'parent' => 'womens-tops'],
            'womens-shirts-blouses' => ['name' => "Women's Shirts & Blouses", 'parent' => 'womens-tops'],
            'womens-sweaters-knitwear' => ['name' => "Women's Sweaters & Knitwear", 'parent' => 'womens-tops'],
            'womens-pullovers' => ['name' => "Women's Pullovers", 'parent' => 'womens-sweaters-knitwear'],
            'womens-turtlenecks' => ['name' => "Women's Turtlenecks", 'parent' => 'womens-sweaters-knitwear'],
            'womens-sweater-vests' => ['name' => "Women's Sweater Vests", 'parent' => 'womens-sweaters-knitwear'],
            'womens-cropped-sweaters' => ['name' => "Women's Cropped Sweaters", 'parent' => 'womens-sweaters-knitwear'],
            'womens-sweatshirts-hoodies' => ['name' => "Women's Sweatshirts & Hoodies", 'parent' => 'womens-tops'],
            'womens-bottoms' => ['name' => "Women's Bottoms", 'parent' => 'womens-clothing'],
            'womens-jeans' => ['name' => "Women's Jeans", 'parent' => 'womens-bottoms'],
            'womens-pants' => ['name' => "Women's Pants", 'parent' => 'womens-bottoms'],
            'skirts' => ['name' => 'Skirts', 'parent' => 'womens-bottoms'],
            'womens-shorts' => ['name' => "Women's Shorts", 'parent' => 'womens-bottoms'],
            'womens-leggings' => ['name' => "Women's Leggings", 'parent' => 'womens-bottoms'],
            'dresses' => ['name' => 'Dresses', 'parent' => 'womens-clothing'],
            'casual-dresses' => ['name' => 'Casual Dresses', 'parent' => 'dresses'],
            'midi-maxi-dresses' => ['name' => 'Midi & Maxi Dresses', 'parent' => 'dresses'],
            'mini-short-dresses' => ['name' => 'Mini & Short Dresses', 'parent' => 'dresses'],
            'party-cocktail-dresses' => ['name' => 'Party & Cocktail Dresses', 'parent' => 'dresses'],
            'knitted-dresses' => ['name' => 'Knitted Dresses', 'parent' => 'dresses'],
            'womens-jumpsuits-rompers' => ['name' => "Women's Jumpsuits & Rompers", 'parent' => 'womens-clothing'],
            'jumpsuits' => ['name' => 'Jumpsuits', 'parent' => 'womens-jumpsuits-rompers'],
            'rompers' => ['name' => 'Rompers', 'parent' => 'womens-jumpsuits-rompers'],
            'womens-outerwear' => ['name' => "Women's Outerwear", 'parent' => 'womens-clothing'],
            'womens-coats' => ['name' => "Women's Coats", 'parent' => 'womens-outerwear'],
            'womens-down-coats' => ['name' => "Women's Down Coats", 'parent' => 'womens-coats'],
            'womens-parkas' => ['name' => "Women's Parkas", 'parent' => 'womens-coats'],
            'womens-wool-blend-coats' => ['name' => "Women's Wool & Blend Coats", 'parent' => 'womens-coats'],
            'womens-jackets' => ['name' => "Women's Jackets", 'parent' => 'womens-outerwear'],
            'womens-bomber-jackets' => ['name' => "Women's Bomber Jackets", 'parent' => 'womens-jackets'],
            'womens-leather-fur-jackets' => ['name' => "Women's Leather & Fur Jackets", 'parent' => 'womens-jackets'],
            'womens-cardigans' => ['name' => "Women's Cardigans", 'parent' => 'womens-outerwear'],
            'womens-matching-sets' => ['name' => "Women's Matching Sets", 'parent' => 'womens-clothing'],
            'pant-sets' => ['name' => 'Pant Sets', 'parent' => 'womens-matching-sets'],
            'short-sets' => ['name' => 'Short Sets', 'parent' => 'womens-matching-sets'],
            'skirt-sets' => ['name' => 'Skirt Sets', 'parent' => 'womens-matching-sets'],
            'sweater-sets' => ['name' => 'Sweater Sets', 'parent' => 'womens-matching-sets'],
            'curve-plus' => ['name' => 'Curve + Plus', 'parent' => 'womens-clothing'],
            'womens-plus-size-tops' => ['name' => "Women's Plus Size Tops", 'parent' => 'curve-plus'],
            'womens-plus-size-bottoms' => ['name' => "Women's Plus Size Bottoms", 'parent' => 'curve-plus'],
            'plus-size-dresses' => ['name' => 'Plus Size Dresses', 'parent' => 'curve-plus'],
            'womens-plus-size-outerwear' => ['name' => "Women's Plus Size Outerwear", 'parent' => 'curve-plus'],
            'womens-plus-size-swimwear' => ['name' => "Women's Plus Size Swimwear", 'parent' => 'curve-plus'],
            'womens-plus-size-matching-sets' => ['name' => "Women's Plus Size Matching Sets", 'parent' => 'curve-plus'],
            'wedding-occasion' => ['name' => 'Wedding & Occasion', 'parent' => 'womens-clothing'],
            'wedding-dresses' => ['name' => 'Wedding Dresses', 'parent' => 'wedding-occasion'],
            'plus-size-wedding-dresses' => ['name' => 'Plus Size Wedding Dresses', 'parent' => 'wedding-dresses'],
            'bespoke-wedding-dresses' => ['name' => 'Bespoke Wedding Dresses', 'parent' => 'wedding-dresses'],
            'special-occasion-dresses' => ['name' => 'Special Occasion Dresses', 'parent' => 'wedding-occasion'],
            'prom-homecoming-dresses' => ['name' => 'Prom & Homecoming Dresses', 'parent' => 'special-occasion-dresses'],
            'evening-formal-dresses' => ['name' => 'Evening & Formal Dresses', 'parent' => 'special-occasion-dresses'],
            'cocktail-dresses' => ['name' => 'Cocktail Dresses', 'parent' => 'special-occasion-dresses'],
            'wedding-party-dresses' => ['name' => 'Wedding Party Dresses', 'parent' => 'wedding-occasion'],
            'wedding-accessories' => ['name' => 'Wedding Accessories', 'parent' => 'wedding-occasion'],

            // Men's Clothing Hierarchy
            'mens-clothing' => ['name' => "Men's Clothing", 'parent' => null],
            'mens-outerwear' => ['name' => "Men's Outerwear", 'parent' => 'mens-clothing'],
            'mens-jackets' => ['name' => "Men's Jackets", 'parent' => 'mens-outerwear'],
            'mens-leather-aviator-jackets' => ['name' => "Men's Leather & Aviator Jackets", 'parent' => 'mens-jackets'],
            'mens-denim-jackets' => ['name' => "Men's Denim Jackets", 'parent' => 'mens-jackets'],
            'mens-baseball-jackets' => ['name' => "Men's Baseball Jackets", 'parent' => 'mens-jackets'],
            'mens-vests' => ['name' => "Men's Vests", 'parent' => 'mens-jackets'],
            'mens-coats' => ['name' => "Men's Coats", 'parent' => 'mens-outerwear'],
            'mens-trench-coats' => ['name' => "Men's Trench Coats", 'parent' => 'mens-coats'],
            'mens-wool-coats' => ['name' => "Men's Wool Coats", 'parent' => 'mens-coats'],
            'mens-down-jackets' => ['name' => "Men's Down Jackets", 'parent' => 'mens-outerwear'],
            'mens-long-down-jackets' => ['name' => "Men's Long Down Jackets", 'parent' => 'mens-down-jackets'],
            'mens-short-down-jackets' => ['name' => "Men's Short Down Jackets", 'parent' => 'mens-down-jackets'],
            'mens-lightweight-down-jackets' => ['name' => "Men's Lightweight Down Jackets", 'parent' => 'mens-down-jackets'],
            'mens-hooded-down-jackets' => ['name' => "Men's Hooded Down Jackets", 'parent' => 'mens-down-jackets'],
            'mens-tops' => ['name' => "Men's Tops", 'parent' => 'mens-clothing'],
            'mens-shirts' => ['name' => "Men's Shirts", 'parent' => 'mens-tops'],
            'mens-casual-shirts' => ['name' => "Men's Casual Shirts", 'parent' => 'mens-shirts'],
            'mens-formal-shirts' => ['name' => "Men's Formal Shirts", 'parent' => 'mens-shirts'],
            'mens-denim-shirts' => ['name' => "Men's Denim Shirts", 'parent' => 'mens-shirts'],
            'mens-cotton-linen-shirts' => ['name' => "Men's Cotton & Linen Shirts", 'parent' => 'mens-shirts'],
            'mens-sweaters-knitwear' => ['name' => "Men's Sweaters & Knitwear", 'parent' => 'mens-tops'],
            'mens-pullovers' => ['name' => "Men's Pullovers", 'parent' => 'mens-sweaters-knitwear'],
            'mens-turtlenecks' => ['name' => "Men's Turtlenecks", 'parent' => 'mens-sweaters-knitwear'],
            'mens-cardigans' => ['name' => "Men's Cardigans", 'parent' => 'mens-sweaters-knitwear'],
            'mens-sweater-vests' => ['name' => "Men's Sweater Vests", 'parent' => 'mens-sweaters-knitwear'],
            'mens-bottoms' => ['name' => "Men's Bottoms", 'parent' => 'mens-clothing'],
            'mens-pants' => ['name' => "Men's Pants", 'parent' => 'mens-bottoms'],
            'mens-casual-pants' => ['name' => "Men's Casual Pants", 'parent' => 'mens-pants'],
            'mens-cargo-pants' => ['name' => "Men's Cargo Pants", 'parent' => 'mens-pants'],
            'mens-sweatpants' => ['name' => "Men's Sweatpants", 'parent' => 'mens-pants'],
            'mens-leather-pants' => ['name' => "Men's Leather Pants", 'parent' => 'mens-pants'],
            'mens-down-pants' => ['name' => "Men's Down Pants", 'parent' => 'mens-pants'],
            'mens-jeans' => ['name' => "Men's Jeans", 'parent' => 'mens-bottoms'],
            'mens-slim-tapered-jeans' => ['name' => "Men's Slim & Tapered Jeans", 'parent' => 'mens-jeans'],
            'mens-baggy-straight-jeans' => ['name' => "Men's Baggy & Straight Jeans", 'parent' => 'mens-jeans'],
            'mens-ripped-washed-jeans' => ['name' => "Men's Ripped & Washed Jeans", 'parent' => 'mens-jeans'],
            'mens-shorts' => ['name' => "Men's Shorts", 'parent' => 'mens-bottoms'],
            'mens-casual-shorts' => ['name' => "Men's Casual Shorts", 'parent' => 'mens-shorts'],
            'mens-denim-shorts' => ['name' => "Men's Denim Shorts", 'parent' => 'mens-shorts'],
            'mens-cargo-shorts' => ['name' => "Men's Cargo Shorts", 'parent' => 'mens-shorts'],
            'mens-gym-board-shorts' => ['name' => "Men's Gym & Board Shorts", 'parent' => 'mens-shorts'],
            'mens-suits-blazers' => ['name' => "Men's Suits & Blazers", 'parent' => 'mens-clothing'],
            'mens-suits' => ['name' => "Men's Suits", 'parent' => 'mens-suits-blazers'],
            'mens-single-breasted-suits' => ['name' => "Men's Single Breasted Suits", 'parent' => 'mens-suits'],
            'mens-double-breasted-suits' => ['name' => "Men's Double Breasted Suits", 'parent' => 'mens-suits'],
            'mens-blazers-suit-jackets' => ['name' => "Men's Blazers & Suit Jackets", 'parent' => 'mens-suits-blazers'],
            'mens-suit-pants' => ['name' => "Men's Suit Pants", 'parent' => 'mens-suits-blazers'],
            'mens-sets' => ['name' => "Men's Sets", 'parent' => 'mens-clothing'],
            'mens-tracksuits-sports-sets' => ['name' => "Men's Tracksuits & Sports Sets", 'parent' => 'mens-sets'],
            'mens-fashion-sets' => ['name' => "Men's Fashion Sets", 'parent' => 'mens-sets'],
        ];
    }
}


if ( ! function_exists( 'elgreco_child_setup_categories' ) ) {
    /**
     * Ensure categories exist and set their hierarchy.
     * This function no longer manages the navigation menu.
     *
     * @return void
     */
    function elgreco_child_setup_categories() {
        // Check if this version has already been run to prevent running on every page load
        if ( get_option( 'elgreco_child_categories_version' ) === ELGRECO_CHILD_CATEGORIES_VERSION && !isset($_GET['force_category_update']) ) {
            return;
        }

        $category_definitions = elgreco_child_get_category_definitions();
        $category_term_ids = [];

        // First pass: create all categories and update names if they differ.
        foreach ($category_definitions as $slug => $data) {
            $term = get_term_by( 'slug', $slug, 'product_cat' );
            $name = $data['name'];
            
            if ( ! $term ) {
                // Term doesn't exist, so create it.
                $term_data = wp_insert_term( $name, 'product_cat', [ 'slug' => $slug ] );
                if ( ! is_wp_error( $term_data ) ) {
                    $category_term_ids[ $slug ] = $term_data['term_id'];
                }
            } else {
                // Term exists, check if name needs updating.
                $category_term_ids[ $slug ] = $term->term_id;
                if ( $term->name !== $name ) {
                    wp_update_term( $term->term_id, 'product_cat', [ 'name' => $name ] );
                }
            }
        }
        
        // Second pass: set up the parent-child relationships now that all terms exist.
        foreach ($category_definitions as $slug => $data) {
            if ( ! empty( $data['parent'] ) ) {
                $parent_term_id = isset( $category_term_ids[ $data['parent'] ] ) ? $category_term_ids[ $data['parent'] ] : 0;
                $child_term_id = isset( $category_term_ids[ $slug ] ) ? $category_term_ids[ $slug ] : 0;

                if ( $child_term_id && $parent_term_id ) {
                    $current_term = get_term($child_term_id, 'product_cat');
                    // Only update if the parent is not already correctly set
                    if ($current_term && $current_term->parent != $parent_term_id) {
                         wp_update_term( $child_term_id, 'product_cat', [ 'parent' => $parent_term_id ] );
                    }
                }
            }
        }

        // Update the version in the database to prevent this from running again.
        update_option( 'elgreco_child_categories_version', ELGRECO_CHILD_CATEGORIES_VERSION );
    }
}

// Run the category setup function on theme initialization.
add_action( 'init', 'elgreco_child_setup_categories', 20 );

