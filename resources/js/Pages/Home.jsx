import React from "react";
import Template from "../components/Template";
import { Carousel, initMDB } from "../js/mdb.es.min";
import { Link, usePage } from "@inertiajs/inertia-react";
import { rupiah } from "../configapp";
const Home = ({ user, transaksi }) => {
    const { auth } = usePage().props;
    initMDB({ Carousel });
    return (
        <div>
            <div
                id="carouselExampleControls"
                className="carousel slide"
                data-mdb-ride="carousel"
                data-mdb-carousel-init=""
            >
                <div className="carousel-inner">
                    <div className="carousel-item active">
                        <img
                            src="img/1.png"
                            className="d-block w-100"
                            alt="Wild Landscape"
                        />
                        <div className="carousel-caption d-md-block"></div>
                    </div>
                    <div className="carousel-item">
                        <img
                            src="img/2.png"
                            className="d-block w-100"
                            alt="Camera"
                        />
                        <div className="carousel-caption d-md-block"></div>
                    </div>
                    <div className="carousel-item">
                        <img
                            src="img/3.png"
                            className="d-block w-100"
                            alt="Exotic Fruits"
                        />
                        <div className="carousel-caption d-md-block"></div>
                    </div>
                </div>
                <button
                    className="carousel-control-prev"
                    type="button"
                    data-mdb-target="#carouselExampleControls"
                    data-mdb-slide="prev"
                >
                    <span
                        className="carousel-control-prev-icon"
                        aria-hidden="true"
                    />
                    <span className="visually-hidden">Previous</span>
                </button>
                <button
                    className="carousel-control-next"
                    type="button"
                    data-mdb-target="#carouselExampleControls"
                    data-mdb-slide="next"
                >
                    <span
                        className="carousel-control-next-icon"
                        aria-hidden="true"
                    />
                    <span className="visually-hidden">Next</span>
                </button>
            </div>
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
                                                            auth.user.saldo
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

            <section className="d-flex p-2">
                <div className="flex-grow-0 fw-bold">Menu Utama</div>
                <div className="flex-grow-1 col-3">
                    <div className="float-end fw-bold">
                        All Menu <i className="fa fa-arrow-right"></i>
                    </div>
                </div>
            </section>
            <ul className="list-group list-group-horizontal position-relative overflow-auto w-100">
                <li className="list-group-item text-center">
                    <Link href="pulsa">
                        <div className="badge badge-primary p-3 rounded-4">
                            <i className="fas fa-mobile fa-2x" />
                        </div>
                        <small className="fw-bold">Beli Pulsa</small>
                    </Link>
                </li>{" "}
                <li className="list-group-item text-center">
                    <Link href="pln">
                        <div className="badge badge-warning p-3 rounded-4">
                            <i className="fas fa-wifi  fa-2x"></i>
                        </div>
                        <small className="fw-bold">TOKEN PLN</small>
                    </Link>
                </li>
                <li className="list-group-item text-center">
                    <Link href="internet">
                        <div className="badge badge-warning p-3 rounded-4">
                            <i className="fas fa-wifi  fa-2x"></i>
                        </div>
                        <small className="fw-bold">Data Internet</small>
                    </Link>
                </li>
                <li className="list-group-item text-center">
                    <Link href="dana">
                        <div className="badge badge-danger p-3 rounded-4">
                            <i className="fas fa-money-bill  fa-2x"></i>
                        </div>
                        <small className="fw-bold">E-wallet Dana</small>
                    </Link>
                </li>
                <li className="list-group-item text-center">
                    <Link href="shopee">
                        <div className="badge badge-success p-3 rounded-4">
                            <i className="fas fa-shopping-bag fa-2x"></i>
                        </div>
                        <small className="fw-bold">E-wallet Shopee</small>
                    </Link>
                </li>
                <li className="list-group-item text-center">
                    <Link href="gopay">
                        <div className="badge badge-info p-3 rounded-4">
                            <i className="fas fa-car fa-2x" />
                        </div>
                        <small className="fw-bold">E-wallet Go Pay</small>
                    </Link>
                </li>
                <li className="list-group-item text-center">
                    <Link href="ml">
                        <div className="badge badge-info p-3 rounded-4">
                            <i className="fas fa-car fa-2x" />
                        </div>
                        <small className="fw-bold">MOBILE LEGENDS</small>
                    </Link>
                </li>
                <li className="list-group-item text-center">
                    <Link href="ff">
                        <div className="badge badge-info p-3 rounded-4">
                            <i className="fas fa-car fa-2x" />
                        </div>
                        <small className="fw-bold">FREE FIRE</small>
                    </Link>
                </li>
            </ul>

            <section className="d-flex p-2">
                <div className="flex-grow-0 fw-bold">Produk</div>
                <div className="flex-grow-1 col-3">
                    <div className="float-end fw-bold">
                        All Menu <i className="fa fa-arrow-right"></i>
                    </div>
                </div>
            </section>
            <ul className="list-group list-group-light p-2">
                {transaksi.map((map, index) => {
                    return (
                        <li className="list-group-item" key={index}>
                            <div className="card">
                                <div className="card-body">
                                    <div className="alert alert-info">
                                        {map.category} - {map.brand}
                                        <br />
                                        {map.nomor}
                                        <br />
                                        {map.trx_id}
                                        <br />
                                        {map.desc}
                                        <br />
                                        {map.price}
                                        <br />
                                        {map.created_at}
                                    </div>
                                    <Link
                                        className="btn btn-primary float-end"
                                        href={"detailtransaksi/" + map.trx_id}
                                    >
                                        Detail
                                        <i className="fa fa-arrow-right"></i>
                                    </Link>
                                </div>
                            </div>
                        </li>
                    );
                })}
            </ul>

            <section className="d-flex p-2">
                <div className="flex-grow-0 fw-bold">Transaksi</div>
                <div className="flex-grow-1 col-3">
                    <div className="float-end fw-bold">
                        All <i className="fa fa-arrow-right"></i>
                    </div>
                </div>
            </section>
            <ul className="list-group list-group-light p-2">
                {transaksi.map((map, index) => {
                    return (
                        <li className="list-group-item" key={index}>
                            <div className="card">
                                <div className="card-body">
                                    <div className="alert alert-info">
                                        {map.category} - {map.brand}
                                        <br />
                                        {map.nomor}
                                        <br />
                                        {map.trx_id}
                                        <br />
                                        {map.desc}
                                        <br />
                                        {map.price}
                                        <br />
                                        {map.created_at}
                                    </div>
                                    <Link
                                        className="btn btn-primary float-end"
                                        href={"detailtransaksi/" + map.trx_id}
                                    >
                                        Detail
                                        <i className="fa fa-arrow-right"></i>
                                    </Link>
                                </div>
                            </div>
                        </li>
                    );
                })}
            </ul>
        </div>
    );
};

Home.layout = (page) => <Template children={page} title="home" />;
export default Home;
