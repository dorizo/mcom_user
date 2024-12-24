import React from "react";
import Template from "../components/Template";
import { Carousel, initMDB } from "../js/mdb.es.min";
import { Link, useForm } from "@inertiajs/inertia-react";
import { Inertia } from "@inertiajs/inertia";
import Swal from "sweetalert2";
import Nonlogin from "../components/Nonlogin";
const Login = () => {
    const { data, setData, post, processing, errors } = useForm({
        phone: "",
        password: "",
    });
    Inertia.on("start", () => {
        let timerInterval;
        Swal.fire({
            title: "Tunggu ... ",
            // html: "I will close in <b></b> milliseconds.",
            didOpen: () => {
                Swal.showLoading();
            },
            willClose: () => {
                clearInterval(timerInterval);
            },
        });
    });
    Inertia.on("finish", () => {
        Swal.close();
    });
    function handleSubmit(e) {
        e.preventDefault();
        post("/login", {
            onSuccess: (page) => {
                console.log(page);
            },
        });
    }
    return (
        <>
            <div>
                <form onSubmit={handleSubmit}>
                    <div className="text-center pb-2"></div>
                    <div className="input-group mb-3">
                        <span className="input-group-text" id="basic-addon1">
                            +62
                        </span>
                        <input
                            type="tel"
                            className="form-control"
                            placeholder="8XXXXXX"
                            aria-label="Username"
                            aria-describedby="basic-addon1"
                            value={data.phone}
                            onChange={(e) => setData("phone", e.target.value)}
                        />
                    </div>
                    {errors.phone && (
                        <div id="emailHelp" className="alert-danger col-12">
                            {errors.phone}
                        </div>
                    )}

                    <div className="mb-3">
                        <label
                            htmlFor="exampleInputPassword1"
                            className="form-label"
                        >
                            Password
                        </label>
                        <input
                            type="password"
                            className="form-control"
                            id="exampleInputPassword1"
                            value={data.password}
                            onChange={(e) =>
                                setData("password", e.target.value)
                            }
                        />
                    </div>
                    <div className="mb-3 form-check">
                        <input
                            type="checkbox"
                            className="form-check-input"
                            id="exampleCheck1"
                        />
                        <label
                            className="form-check-label"
                            htmlFor="exampleCheck1"
                        >
                            Check me out
                        </label>
                    </div>
                    <button type="submit" className="btn btn-success">
                        Login
                    </button>

                    <div className="text-center pt-2">
                        <p>
                            <Link href="#!"> Lupa Password </Link>
                        </p>
                        <p>
                            <Link href="register">
                                Tidak Punya Akun? daftar{" "}
                            </Link>
                        </p>
                    </div>
                </form>
            </div>
        </>
    );
};
Login.layout = (page) => <Nonlogin children={page} title="topup" />;
export default Login;
