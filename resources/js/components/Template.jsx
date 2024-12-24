import { Inertia } from "@inertiajs/inertia";
import { Head, Link } from "@inertiajs/inertia-react";
import { Modal, Ripple, initMDB } from "../js/mdb.es.min";
import Swal from "sweetalert2";
import { useEffect, useState } from "react";

const Template = ({ children }) => {
    const [datanotif, SetDatanotif] = useState(0);
    function handleSubmit(e) {
        e.preventDefault();
        console.log("You clicked submit.");
    }

    useEffect(() => {
        window.Echo.channel("my-channel").listen(".my-event", (event) => {
            // console.log("ChangeEvent received:", event);
            if (event && event != undefined) {
                console.log(event.message.ppspspsp);
                SetDatanotif(2);
            }
        });
        return () =>
            window.Echo.channel("my-channel").stopListening(".my-event");
    }, [datanotif]);
    initMDB({ Modal, Ripple });
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
    return (
        <>
            <Head>
                <title>HALAL ECOSYSTEM</title>
            </Head>
            <header>
                <nav className="navbar navbar-expand-lg navbar-light bg-body-tertiary">
                    <div className="container-fluid">
                        <div>
                            <img src="img/mcom.png" width="50px" />
                        </div>
                        <div
                            className="collapse navbar-collapse"
                            id="navbarSupportedContent"
                        ></div>
                        <div className="d-flex align-items-center">
                            <a
                                type="button"
                                data-mdb-toggle="modal"
                                data-mdb-target="#exampleModal"
                                data-mdb-ripple-init
                                data-mdb-modal-init
                            >
                                <i className="fa-solid fa-arrow-right-from-bracket"></i>
                            </a>
                        </div>
                    </div>
                </nav>
            </header>
            <main className="pb-5">{children}</main>
            <nav className="fixed-bottom btn-group shadow-lg">
                <Link className="btn btn-success" href="/">
                    <i className="fas fa-home fa-lg text-white" />
                    <br />
                    <small className="text-white">Home</small>
                </Link>
                <Link className="btn btn-success" href="news">
                    <i className="fas fa-book fa-lg text-white" />
                    <br />
                    <small className="text-white">sosmed</small>
                </Link>
                <Link className="btn btn-success" href="bantuan">
                    <i className="fas fa-question-circle fa-lg text-white" />
                    <br />
                    <small className="text-white">lapor</small>
                </Link>

                <Link className="btn btn-success" href="notification">
                    <i className="fas fa-bell fa-lg text-white"></i>
                    {datanotif == 0 ? (
                        ""
                    ) : (
                        <span className="badge bg-danger ms-2">
                            {datanotif}
                        </span>
                    )}
                    <br />
                    <small className="text-white">notification</small>
                </Link>
            </nav>

            <div
                className="modal fade"
                id="exampleModal"
                tabIndex={-1}
                aria-labelledby="exampleModalLabel"
                aria-hidden="true"
            >
                <div className="modal-dialog">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h5 className="modal-title" id="exampleModalLabel">
                                Keluar Aplikasi
                            </h5>
                            <button
                                type="button"
                                className="btn-close"
                                data-mdb-dismiss="modal"
                                aria-label="Close"
                            />
                        </div>
                        <div className="modal-body">
                            <div className="h6">
                                Apakah anda Ingin keluar dari aplikasi?
                            </div>
                        </div>
                        <div className="modal-footer">
                            <button
                                type="button"
                                className="btn btn-secondary"
                                data-mdb-dismiss="modal"
                            >
                                Tidak
                            </button>
                            <button
                                type="button"
                                onClick={handleSubmit}
                                className="btn btn-success"
                            >
                                YA
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};
export default Template;
