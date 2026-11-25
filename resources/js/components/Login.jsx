import { useState } from "react";

function Login() {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [error, setError] = useState(null);
    const [loggedIn, setLoggedIn] = useState(!!localStorage.getItem("token"));

    function handleSubmit(e) {
        e.preventDefault(); //prevent from refresh
        setError(null);

        fetch("/api/login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify({ email, password }), // like raw in laravel
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Invalid Credentials");
                }
                return response.json();
            })
            .then((data) => {
                localStorage.setItem("token", data.token); //set token if response
                setLoggedIn(true);
            })
            .catch((err) => setError(err.message));
    }

    function handleLogout() {
        localStorage.removeItem("token"); //delete token to logout
        setLoggedIn(false);
    }

    if (loggedIn)
        return (
            <div>
                <p>You are logged in ✅</p>
                <button onClick={handleLogout} className="btn btn-outline-dark">Logout</button>
            </div>
        );

    return (
        <div>
            {error && <p>{error}</p>}
            <form onSubmit={handleSubmit} className="form" style={{ display: "flex", gap: 8 }}>
                <input
                    placeholder="Write Your Email"
                    value={email}
                    type="email"
                    onChange={(e) => setEmail(e.target.value)}
                />
                <input
                    placeholder="Write Your Password"
                    value={password}
                    type="password"
                    onChange={(e) => setPassword(e.target.value)}
                />
                <button type="submit" className="btn btn-primary"> Login </button>
            </form>
        </div>
    );
}

export default Login;
