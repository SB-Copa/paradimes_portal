import ReactDOM from 'react-dom/client';
import './index.css'
import { createBrowserRouter, RouterProvider } from 'react-router';
import Home from './pages/home/Home';

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
