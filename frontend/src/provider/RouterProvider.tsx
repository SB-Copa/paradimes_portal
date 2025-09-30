import ReactDOM from "react-dom/client";
import { createBrowserRouter } from "react-router";
import { RouterProvider } from "react-router/dom";
import Home from "../pages/home/Home";

const router = createBrowserRouter([
    {
        path: "/",
        element: <Home />,
    },
]);

const root = document.getElementById("root") as HTMLElement;

ReactDOM.createRoot(root).render(
    <RouterProvider router={router} />,
);
