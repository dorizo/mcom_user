import { Link, useForm, usePage } from "@inertiajs/inertia-react";
import React, { Component } from "react";
import Subtemplate from "../components/Subtemplate";
import { rupiah } from "../configapp";
import Swal from "sweetalert2";
import { Inertia } from "@inertiajs/inertia";
import Template from "../components/Template";

const mcom = ({ user, transaksi }) => {
    const { auth } = usePage().props;
    return (
        <>
            <div className="d-flex sub-bg align-items-center justify-content-center">
                <div className="sub-title fs-2">
                    <img src="img/mcom.png" width={150} className="pt-3" />
                </div>
            </div>
            <div className="container sub-content bg-white">
                <div className="card">
                    <div>
                        <div className="col-12">
                            <div className="card">
                                <div className="card-body">
                                    <div className="d-flex">
                                        <div className="d-flex align-items-center justify-content-center">
                                            <img
                                                src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-profiles/avatar-1.webp"
                                                alt="Generic placeholder image"
                                                className="img-thumbnail"
                                                style={{
                                                    width: 100,
                                                    borderRadius: 10,
                                                }}
                                            />
                                        </div>
                                        <div className="flex-grow-1 ms-3">
                                            <div className="mb-1">
                                                {auth.user.name}
                                                <br />
                                                <b>{auth.user.akun}</b>
                                            </div>

                                            <small className="mt-1">
                                                <h6 className="alert alert-warning p-2">
                                                    <div className="d-flex">
                                                        <div className="flex-grow-0">
                                                            <small className="fw-bold">
                                                                Saldo
                                                                <br />
                                                                {rupiah(
                                                                    auth.user
                                                                        .saldo
                                                                )}
                                                            </small>
                                                        </div>
                                                        <div className="flex-grow-1 float-end align-self-center">
                                                            <Link
                                                                href="/topup"
                                                                className="btn btn-sm btn-danger float-end"
                                                            >
                                                                Topup
                                                            </Link>
                                                        </div>
                                                    </div>
                                                </h6>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-12 pt-2">
                    <div className="row">
                        <div className="col-4 pt-2">
                            <Link className="card">
                                <img src="img/icon/1.png" width="100%" />
                            </Link>
                        </div>
                        <div className="col-4 pt-2">
                            <Link className="card">
                                <img src="img/icon/2.png" width="100%" />
                            </Link>
                        </div>
                        <div className="col-4 pt-2">
                            <Link className="card">
                                <img src="img/icon/3.png" width="100%" />
                            </Link>
                        </div>
                        <div className="col-4 pt-2">
                            <Link className="card">
                                <img src="img/icon/4.png" width="100%" />
                            </Link>
                        </div>
                        <div className="col-4 pt-2">
                            <Link className="card">
                                <img src="img/icon/5.png" width="100%" />
                            </Link>
                        </div>
                        <div className="col-4 pt-2">
                            <Link className="card">
                                <img src="img/icon/6.png" width="100%" />
                            </Link>
                        </div>

                        <div className="col-4 pt-2">
                            <Link className="card">
                                <img src="img/icon/7.png" width="100%" />
                            </Link>
                        </div>
                        <div className="col-4 pt-2">
                            <Link className="card">
                                <img src="img/icon/8.png" width="100%" />
                            </Link>
                        </div>
                        <div className="col-4 pt-2">
                            <Link className="card">
                                <img src="img/icon/9.png" width="100%" />
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

mcom.layout = (page) => <Template children={page} title="topup" />;
export default mcom;
