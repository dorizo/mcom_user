import React from "react";
import Template from "../components/Template";
import { Carousel, initMDB } from "../js/mdb.es.min";
import { Link, useForm } from "@inertiajs/inertia-react";
import { Inertia } from "@inertiajs/inertia";
import Swal from "sweetalert2";
import Nonlogin from "../components/Nonlogin";
const Register = () => {
    const { data, setData, post, processing, errors } = useForm({
        phone: "",
        name: "",
        email: "",
        alamat: "",
        password: "",
        password_confirmation: "",
    });
    Inertia.on("start", () => {
        let timerInterval;
        Swal.fire({
            title: "Tunggu ... ",
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
        post("/register", {
            onSuccess: (page) => {
                console.log(page);
            },
        });
    }
    return (
        <>
            <form onSubmit={handleSubmit}>
                <div className="text-center pb-2">
                    <img src="img/mcom.png" width={100} />
                </div>
                <div className="form-group">
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
                    </div>{" "}
                    {errors.phone && (
                        <div id="emailHelp" className="alert-danger col-12">
                            {errors.phone}
                        </div>
                    )}
                </div>
                <div className="mb-3">
                    <label
                        htmlFor="exampleInputPassword1"
                        className="form-label"
                    >
                        nama lengkap
                    </label>
                    <input
                        type="text"
                        name="name"
                        className="form-control"
                        id="exampleInputPassword1"
                        value={data.name}
                        onChange={(e) => setData("name", e.target.value)}
                    />
                    {errors.name && (
                        <div id="emailHelp" className="alert-danger col-12">
                            {errors.name}
                        </div>
                    )}
                </div>

                <div className="mb-3">
                    <label
                        htmlFor="exampleInputPassword1"
                        className="form-label"
                    >
                        alamat
                    </label>
                    <input
                        type="text"
                        name="alamat"
                        className="form-control"
                        id="exampleInputPassword1"
                        value={data.alamat}
                        onChange={(e) => setData("alamat", e.target.value)}
                    />
                    {errors.alamat && (
                        <div className="alert-danger col-12">
                            {errors.alamat}
                        </div>
                    )}
                </div>

                <div className="mb-3">
                    <label
                        htmlFor="exampleInputPassword1"
                        className="form-label"
                    >
                        email
                    </label>
                    <input
                        type="email"
                        className="form-control"
                        id="exampleInputPassword1"
                        value={data.email}
                        onChange={(e) => setData("email", e.target.value)}
                    />
                    {errors.email && (
                        <div className="alert-danger col-12">
                            {errors.email}
                        </div>
                    )}
                </div>
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
                        onChange={(e) => setData("password", e.target.value)}
                    />

                    {errors.password && (
                        <div className="alert-danger col-12">
                            {errors.password}
                        </div>
                    )}
                </div>
                <div className="mb-3">
                    <label
                        htmlFor="exampleInputPassword1"
                        className="form-label"
                    >
                        Password confirm
                    </label>
                    <input
                        type="password"
                        className="form-control"
                        id="exampleInputPassword1"
                        value={data.password_confirmation}
                        onChange={(e) =>
                            setData("password_confirmation", e.target.value)
                        }
                    />
                </div>
                <input
                    type="submit"
                    className="btn btn-success btn-block"
                    value={"input"}
                />

                <div className="text-center pt-2">
                    <p>
                        <Link href="#!"> Lupa Password </Link>
                    </p>
                    <p>
                        <Link href="login">Sudah Punya Akun</Link>
                    </p>
                </div>
            </form>
        </>
    );
};
Register.layout = (page) => <Nonlogin children={page} title="topup" />;
export default Register;
