import React, { useState, useEffect } from "react";

// ###################### States #####################
// Products component
function Products() {
    //All Products
    const [products, setProducts] = useState([]); // State to hold the list of products

    // Handle Loading and Errors
    const [loading, setLoading] = useState(true); // State to track loading status
    const [error, setError] = useState(null); // State to track any errors
    const [detailsError, setDetailsError] = useState(null); // State to track any errors when fetching product details

    // Show selected product
    const [selectedId, setSelectedId] = useState(null); // for selected product id
    const [selectedproduct, setSelectedProduct] = useState(null); // State to hold the selected product details

    // Search and Fliter
    const [search, setSearch] = useState("");
    const [minPrice, setMinPrice] = useState("");
    const [maxPrice, setMaxPrice] = useState("");

    // ###################### Fetching Data ######################
    // All Products and Search & Filter using params
    useEffect(() => {
        let ignore = false;
        setLoading(true);
        setError(null);

        const params = new URLSearchParams(); //deal with spaces and letters and important for search
        if (search) params.append("search", search); //Filter phone by min and max price
        if (minPrice) params.append("min_price", minPrice);
        if (maxPrice) params.append("max_price", maxPrice);
        fetch(`/api/products?${params}`, {
            headers: { "Accept-Language": "en" },
        })
            .then((response) => {
                // Convert the response to JSON , then is used to handle the promise returned by the fetch call
                if (!response.ok) throw new Error("Failed to fetch Products"); // Throw an error if the response is not ok
                return response.json(); // Convert the response to JSON
            })
            .then((data) => {
                if (!ignore) setProducts(data.products ?? []);
            }) // Update the state with the fetched products
            .catch((err) => setError(err.message)) // Handle any errors
            .finally(() => setLoading(false)); // Set loading to false once the request is complete
        return () => {
            ignore = true;
        }; // cleanup function to prevent state update(like: "ph", "phone", "iphon", "iphone" so many requests will be sent to the server, but we only want the last one to be processed)
    }, [search, minPrice, maxPrice]); // dependency array

    // Show selected product details when selectedId changes
    useEffect(() => {
        if (!selectedId) return;
        setDetailsError(null); // Reset any previous error messages
        fetch(`/api/show/product/${selectedId}`, {
            headers: { "Accept-Language": "en" },
        }) // Fetch the selected product details from the API
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Failed to fetch product details"); // Throw an error if the response is not ok
                }
                return response.json(); // Convert the response to JSON
            })
            .then((data) => setSelectedProduct(data.product)) // Update the state with the fetched product details
            .catch((err) => setDetailsError(err.message));
    }, [selectedId]); // Dependency array includes selectedId, so this effect runs whenever selectedId changes

    // Delete by id
    function handleDelete(id) {
        const token = localStorage.getItem("token");
        if (!window.confirm("Are you sure you want to delete this Product?"))
            return;
        fetch(`/api/delete/product/${id}`, {
            method: "DELETE",
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            },
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Failed To Delete Product");
                }
                setProducts((prev) => prev.filter((p) => p.id !== id)); // filter is to delete the product by id from state so it can be deleted without refresh
                if (id === selectedId) {
                    setSelectedProduct(null); //delete details if showns
                    setSelectedId(null); //delete the selected navigator
                }
            })
            .catch((err) => alert(err.message));
    }

    // ###################### Rendering ######################
    // Render the list of products
    return (
        <div>
            {/* Product List */}
            <h1>Products</h1>
            {/* Fliter with css  */}
            <div className="filters">
                <input
                    placeholder="Seaching..."
                    value={search}
                    onChange={(e) => setSearch(e.target.value)}
                />
                <input
                    type="number"
                    placeholder="Min Price"
                    value={minPrice}
                    onChange={(e) => setMinPrice(e.target.value)}
                />
                <input
                    type="number"
                    placeholder="Max Price"
                    value={maxPrice}
                    onChange={(e) => setMaxPrice(e.target.value)}
                />
            </div>
            {loading && <p className="muted">Loading....</p>}{" "}
            {/* Show loading message while fetching data */}
            {!loading && !error && products.length === 0 && (
                <p>No products found</p>
            )}
            {error && <p className="alert alert-error">Error.... {error}</p>}{" "}
            {/* Show error message if there was an error */}
            {!loading && !error && (
                <ul className="product-list">
                    {products.map(
                        (
                            product, // map is to iterate over the products array and render each product as a list item
                        ) => (
                            // Render each product as a list item with an onClick event to set the selected product ID like in laravel (foreach)
                            <li
                                key={product.id}
                                className={`product-item ${product.id === selectedId ? "active" : ""}`}
                                onClick={() => setSelectedId(product.id)}
                                style={{
                                    cursor: "pointer",
                                    fontWeight:
                                        product.id === selectedId
                                            ? "bold"
                                            : "normal",
                                }}
                            >
                                <span>{product.title}</span>
                                <span className="price">{product.price}</span>
                                {product.title}
                                <button
                                    type="button"
                                    className="btn btn-danger"
                                    onClick={(e) => {
                                        e.stopPropagation();  // to click on delete only not also on product to show details
                                        handleDelete(product.id);
                                    }}
                                >
                                    Delete
                                </button>
                            </li>
                        ),
                    )}
                </ul>
            )}
            {/* Show Product Details */}
            {detailsError && <p>{detailsError}</p>}{" "}
            {/* Show error message if there was an error fetching product details */}
            {selectedproduct && (
                <div className="details">
                    <h2>Title: {selectedproduct.title}</h2>
                    <p>Description: {selectedproduct.description}</p>
                    <p>Price: {selectedproduct.price}</p>
                    {/* Render other product details as needed */}
                </div>
            )}
            {/* <p>Selected ID: {selectedId}</p> */}
        </div>
    );
}

export default Products;
